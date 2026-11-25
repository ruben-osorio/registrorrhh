<?php
/**
 * Dashboard de personal (inicio del administrador).
 *
 * Definiciones:
 *  - Planta activa: registro más reciente de `permanente` con status = 1.
 *  - Consultor activo: contrato más reciente con status = 1 (sin contar a quien ya es planta activa).
 * Los gráficos se dibujan en el servidor (HTML/CSS y SVG); solo los tooltips usan JavaScript.
 */
require_once("security.php");

if ((string) ($_SESSION['permisos'] ?? '') !== '0') {
	echo '<p>Acceso restringido.</p>';
	return;
}

/* -------------------------------------------------------------------------
 * Utilidades
 * ---------------------------------------------------------------------- */

function dash_e($s)
{
	return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

function dash_n($n)
{
	return number_format((float) $n, 0, ',', '.');
}

function dash_pct($parte, $total)
{
	return $total > 0 ? round($parte * 100 / $total) : 0;
}

function dash_filas($db, $sql)
{
	$filas = array();
	$res = mysqli_query($db, $sql);
	if ($res) {
		while ($f = mysqli_fetch_assoc($res)) {
			$filas[] = $f;
		}
		mysqli_free_result($res);
	}
	return $filas;
}

function dash_fecha_valida($f)
{
	return $f && $f > '1900-01-01' && $f <= date('Y-m-d');
}

/** Años cumplidos entre $fecha y $referencia (por defecto, hoy). */
function dash_anios_desde($fecha, $referencia = 'today')
{
	$d = date_create($fecha);
	return $d ? (int) date_diff($d, date_create($referencia))->y : null;
}

/** Corrige texto con doble codificación UTF-8 (p. ej. "DISEÃ‘O" -> "DISEÑO"). */
function dash_txt($s)
{
	$s = trim(preg_replace('/\s+/', ' ', (string) $s));
	if (preg_match('/[ÃÂ][\x{80}-\x{FFFF}]/u', $s)) {
		$r = mb_convert_encoding($s, 'Windows-1252', 'UTF-8');
		if (mb_check_encoding($r, 'UTF-8')) {
			return $r;
		}
	}
	return $s;
}

/** Formatea una fecha Y-m-d como d/m/Y. */
function dash_fecha($f)
{
	return ($f && $f > '1900-01-01') ? date('d/m/Y', strtotime($f)) : '—';
}

/** Lista compacta con título y detalle (para tarjetas de resumen). */
function dash_lista($items, $max)
{
	$h = '<ul class="dash-list">';
	foreach (array_slice($items, 0, $max) as $it) {
		$h .= '<li><span class="dash-li-t" title="' . dash_e($it['titulo']) . '">' . dash_e($it['titulo']) . '</span>'
			. '<span class="dash-li-d">' . dash_e($it['detalle']) . '</span></li>';
	}
	return $h . '</ul>';
}

/** Descarta registros de prueba o sin contenido real. */
function dash_cargo_valido($cargo)
{
	return mb_strlen($cargo) >= 5
		&& !preg_match('/^X+$/i', $cargo)
		&& !in_array($cargo, array('HACKER', 'PRUEBA', 'TEST', 'NINGUNO'), true);
}

/** Escala "redonda" para el eje Y: devuelve [máximo, paso]. */
function dash_escala($max)
{
	$max = max(1, $max);
	$crudo = $max / 4;
	$pot = pow(10, floor(log10($crudo)));
	$paso = 10 * $pot;
	foreach (array(1, 2, 5, 10) as $f) {
		if ($f * $pot >= $crudo) {
			$paso = $f * $pot;
			break;
		}
	}
	$paso = max(1, $paso);
	return array(ceil($max / $paso) * $paso, $paso);
}

/** Agrupa en las N categorías más grandes + "Otras". */
function dash_top($conteo, $n, $etiquetaOtras)
{
	arsort($conteo);
	$top = array_slice($conteo, 0, $n, true);
	$resto = array_slice($conteo, $n, null, true);
	if ($resto) {
		$top[sprintf($etiquetaOtras, count($resto))] = array_sum($resto);
	}
	return $top;
}

/* -------------------------------------------------------------------------
 * Componentes de visualización
 * ---------------------------------------------------------------------- */

/** Tabla accesible con los datos de un gráfico. */
function dash_tabla($datos, $colCategoria, $colValor)
{
	$h = '<details class="dash-datos"><summary>Ver datos</summary><table><thead><tr><th>'
		. dash_e($colCategoria) . '</th><th class="num">' . dash_e($colValor) . '</th></tr></thead><tbody>';
	foreach ($datos as $k => $v) {
		$h .= '<tr><td>' . dash_e($k) . '</td><td class="num">' . dash_n($v) . '</td></tr>';
	}
	return $h . '</tbody></table></details>';
}

/** Barras horizontales (ranking). */
function dash_barras_h($datos, $color, $unidad)
{
	$max = max(1, max($datos ?: array(1)));
	$h = '<div class="dash-hbars">';
	foreach ($datos as $etiqueta => $valor) {
		$ancho = max(0.5, $valor * 100 / $max);
		$h .= '<div class="dash-hrow" tabindex="0" data-tip="' . dash_e($etiqueta . ': ' . dash_n($valor) . ' ' . $unidad) . '">'
			. '<span class="dash-hlabel" title="' . dash_e($etiqueta) . '">' . dash_e($etiqueta) . '</span>'
			. '<span class="dash-htrack"><span class="dash-hfill" style="width:' . round($ancho, 2) . '%;background:' . $color . '"></span></span>'
			. '<span class="dash-hval">' . dash_n($valor) . '</span></div>';
	}
	return $h . '</div>';
}

/** Columnas verticales (distribuciones) en SVG. */
function dash_columnas($datos, $color, $unidad)
{
	$w = 460; $alto = 230; $izq = 38; $der = 8; $arr = 22; $aba = 30;
	$pw = $w - $izq - $der;
	$ph = $alto - $arr - $aba;
	list($tope, $paso) = dash_escala(max($datos ?: array(1)));
	$n = max(1, count($datos));
	$banda = $pw / $n;
	$ancho = min(56, $banda * 0.62);
	$base = $arr + $ph;

	$s = '<svg class="dash-svg" viewBox="0 0 ' . $w . ' ' . $alto . '" role="img" preserveAspectRatio="xMidYMid meet">';
	for ($v = 0; $v <= $tope; $v += $paso) {
		$y = round($base - $ph * $v / $tope, 1);
		$s .= '<line class="' . ($v == 0 ? 'dash-axis' : 'dash-grid') . '" x1="' . $izq . '" x2="' . ($w - $der) . '" y1="' . $y . '" y2="' . $y . '"/>';
		$s .= '<text class="dash-tick" x="' . ($izq - 6) . '" y="' . ($y + 4) . '" text-anchor="end">' . dash_n($v) . '</text>';
	}
	$i = 0;
	foreach ($datos as $etiqueta => $valor) {
		$cx = $izq + $banda * $i + $banda / 2;
		$x = round($cx - $ancho / 2, 1);
		$bh = $ph * $valor / $tope;
		$y = $base - $bh;
		$r = min(4, $bh, $ancho / 2);
		$tip = dash_e($etiqueta . ': ' . dash_n($valor) . ' ' . $unidad);
		$s .= '<g class="dash-col" tabindex="0" data-tip="' . $tip . '">';
		$s .= '<rect class="dash-hit" x="' . round($izq + $banda * $i, 1) . '" y="' . $arr . '" width="' . round($banda, 1) . '" height="' . $ph . '"/>';
		if ($bh > 0) {
			$s .= '<path fill="' . $color . '" d="M' . $x . ',' . round($base, 1) . ' V' . round($y + $r, 1)
				. ' Q' . $x . ',' . round($y, 1) . ' ' . round($x + $r, 1) . ',' . round($y, 1)
				. ' H' . round($x + $ancho - $r, 1)
				. ' Q' . round($x + $ancho, 1) . ',' . round($y, 1) . ' ' . round($x + $ancho, 1) . ',' . round($y + $r, 1)
				. ' V' . round($base, 1) . ' Z"/>';
		}
		$s .= '<text class="dash-val" x="' . round($cx, 1) . '" y="' . round($y - 6, 1) . '" text-anchor="middle">' . dash_n($valor) . '</text>';
		$s .= '<text class="dash-xlab" x="' . round($cx, 1) . '" y="' . ($base + 18) . '" text-anchor="middle">' . dash_e($etiqueta) . '</text>';
		$s .= '</g>';
		$i++;
	}
	return $s . '</svg>';
}

/** Líneas por año (varias series, una sola escala). */
function dash_lineas($anios, $series, $unidad)
{
	$w = 940; $alto = 250; $izq = 40; $der = 110; $arr = 18; $aba = 30;
	$pw = $w - $izq - $der;
	$ph = $alto - $arr - $aba;
	$base = $arr + $ph;
	$maximo = 1;
	foreach ($series as $se) {
		$maximo = max($maximo, max($se['valores'] ?: array(0)));
	}
	list($tope, $paso) = dash_escala($maximo);
	$n = count($anios);
	$dx = $n > 1 ? $pw / ($n - 1) : 0;
	$px = function ($i) use ($izq, $dx) { return round($izq + $dx * $i, 1); };
	$py = function ($v) use ($base, $ph, $tope) { return round($base - $ph * $v / $tope, 1); };

	$s = '<svg class="dash-svg" viewBox="0 0 ' . $w . ' ' . $alto . '" role="img" preserveAspectRatio="xMidYMid meet">';
	for ($v = 0; $v <= $tope; $v += $paso) {
		$y = $py($v);
		$s .= '<line class="' . ($v == 0 ? 'dash-axis' : 'dash-grid') . '" x1="' . $izq . '" x2="' . ($izq + $pw) . '" y1="' . $y . '" y2="' . $y . '"/>';
		$s .= '<text class="dash-tick" x="' . ($izq - 6) . '" y="' . ($y + 4) . '" text-anchor="end">' . dash_n($v) . '</text>';
	}
	foreach ($anios as $i => $anio) {
		$s .= '<text class="dash-xlab" x="' . $px($i) . '" y="' . ($base + 18) . '" text-anchor="middle">' . $anio . '</text>';
	}
	// Columnas de interacción (cruz + tooltip por año)
	foreach ($anios as $i => $anio) {
		$tip = $anio;
		foreach ($series as $se) {
			$tip .= ' · ' . $se['nombre'] . ': ' . dash_n($se['valores'][$i]);
		}
		$x0 = $n > 1 ? max($izq, $px($i) - $dx / 2) : $izq;
		$x1 = $n > 1 ? min($izq + $pw, $px($i) + $dx / 2) : $izq + $pw;
		$s .= '<g class="dash-cross" tabindex="0" data-tip="' . dash_e($tip . ' ' . $unidad) . '">'
			. '<rect class="dash-hit" x="' . round($x0, 1) . '" y="' . $arr . '" width="' . round($x1 - $x0, 1) . '" height="' . $ph . '"/>'
			. '<line class="dash-guide" x1="' . $px($i) . '" x2="' . $px($i) . '" y1="' . $arr . '" y2="' . $base . '"/></g>';
	}
	// Series
	$finales = array();
	foreach ($series as $se) {
		$pts = array();
		foreach ($se['valores'] as $i => $v) {
			$pts[] = $px($i) . ',' . $py($v);
		}
		$s .= '<polyline class="dash-line" stroke="' . $se['color'] . '" points="' . implode(' ', $pts) . '"/>';
		foreach ($se['valores'] as $i => $v) {
			$s .= '<circle class="dash-dot" cx="' . $px($i) . '" cy="' . $py($v) . '" r="4" fill="' . $se['color'] . '"/>';
		}
		$ultimo = end($se['valores']);
		$finales[] = array('y' => $py($ultimo), 'texto' => $se['nombre'] . ' ' . dash_n($ultimo), 'color' => $se['color']);
	}
	// Etiquetas directas al final de cada línea (separadas si se superponen)
	usort($finales, function ($a, $b) { return $a['y'] <=> $b['y']; });
	$prev = -100;
	foreach ($finales as $f) {
		$y = max($f['y'], $prev + 16);
		$prev = $y;
		$x = $izq + $pw + 10;
		$s .= '<circle cx="' . $x . '" cy="' . round($y - 4, 1) . '" r="4" fill="' . $f['color'] . '"/>'
			. '<text class="dash-endlab" x="' . ($x + 9) . '" y="' . round($y, 1) . '">' . dash_e($f['texto']) . '</text>';
	}
	return $s . '</svg>';
}

/* -------------------------------------------------------------------------
 * Datos
 * ---------------------------------------------------------------------- */

$dashDb = ssrp_mysqli_connect();
if (!$dashDb) {
	echo '<div class="dash-root"><p class="dash-aviso">No se pudo conectar a la base de datos para generar el dashboard.</p></div>';
	return;
}

$COLOR_PLANTA = '#2a78d6';
$COLOR_CONSULTOR = '#eb6834';
$COLOR_MUJERES = '#1baf7a';
$COLOR_HOMBRES = '#6250d6';
$COLOR_BAJAS = '#e34948';

// Fecha de corte: último movimiento registrado (ingreso de planta, contrato o baja).
// Los indicadores de tiempo se calculan a esta fecha para que reflejen el estado de la base.
$ultimo = dash_filas($dashDb, "SELECT GREATEST(
	IFNULL((SELECT MAX(date_ent) FROM permanente WHERE date_ent <= CURDATE()), '1900-01-01'),
	IFNULL((SELECT MAX(date_ent) FROM contrato WHERE date_ent <= CURDATE()), '1900-01-01'),
	IFNULL((SELECT MAX(date_efect) FROM baja WHERE date_efect <= CURDATE()), '1900-01-01')) f");
$corte = ($ultimo && $ultimo[0]['f'] > '1900-01-01') ? $ultimo[0]['f'] : date('Y-m-d');
$fechaDatos = dash_fecha($corte);

// Personal activo
$planta = dash_filas($dashDb, "SELECT p.id_func, p.id_per, p.date_ent FROM permanente p
	JOIN (SELECT id_func, MAX(id_per) id_per FROM permanente WHERE status = 1 GROUP BY id_func) x
	  ON x.id_func = p.id_func AND x.id_per = p.id_per");
$plantaPorFunc = array();
foreach ($planta as $p) {
	$plantaPorFunc[(int) $p['id_func']] = $p;
}
$consultores = array();
foreach (dash_filas($dashDb, "SELECT c.id_func, c.id_con, c.date_ent FROM contrato c
	JOIN (SELECT id_func, MAX(id_con) id_con FROM contrato WHERE status = 1 GROUP BY id_func) x
	  ON x.id_func = c.id_func AND x.id_con = c.id_con") as $c) {
	if (!isset($plantaPorFunc[(int) $c['id_func']])) {
		$consultores[(int) $c['id_func']] = $c;
	}
}
$idsActivos = array_merge(array_keys($plantaPorFunc), array_keys($consultores));
$totalPlanta = count($plantaPorFunc);
$totalConsultores = count($consultores);
$totalActivos = $totalPlanta + $totalConsultores;

// Datos personales del personal activo
$funcionarios = array();
if ($idsActivos) {
	foreach (dash_filas($dashDb, "SELECT id_func, name, l_name1, l_name2, sex, date_born FROM funcionario
		WHERE id_func IN (" . implode(',', array_map('intval', $idsActivos)) . ")") as $f) {
		$funcionarios[(int) $f['id_func']] = $f;
	}
}

// Sexo y edad
$sexo = array('Mujeres' => 0, 'Hombres' => 0);
$sinSexo = 0;
$edades = array('Menos de 30' => 0, '30 a 39' => 0, '40 a 49' => 0, '50 a 59' => 0, '60 o más' => 0);
$sumaEdad = 0;
$conEdad = 0;
$cumpleanos = array();
$mesActual = (int) date('n');
foreach ($funcionarios as $id => $f) {
	$sx = strtoupper(trim((string) $f['sex']));
	if ($sx === 'FEMENINO' || $sx === 'F') {
		$sexo['Mujeres']++;
	} elseif ($sx === 'MASCULINO' || $sx === 'M') {
		$sexo['Hombres']++;
	} else {
		$sinSexo++;
	}
	if (dash_fecha_valida($f['date_born'])) {
		$edad = dash_anios_desde($f['date_born'], $corte);
		if ($edad !== null && $edad >= 16 && $edad <= 100) {
			$sumaEdad += $edad;
			$conEdad++;
			if ($edad < 30) $edades['Menos de 30']++;
			elseif ($edad < 40) $edades['30 a 39']++;
			elseif ($edad < 50) $edades['40 a 49']++;
			elseif ($edad < 60) $edades['50 a 59']++;
			else $edades['60 o más']++;
		}
		if ((int) substr($f['date_born'], 5, 2) === $mesActual) {
			$cumpleanos[] = array(
				'dia' => (int) substr($f['date_born'], 8, 2),
				'nombre' => trim($f['name'] . ' ' . $f['l_name1'] . ' ' . $f['l_name2']),
				'cumple' => (int) date('Y') - (int) substr($f['date_born'], 0, 4),
				'tipo' => isset($plantaPorFunc[$id]) ? 'Planta' : 'Consultor',
			);
		}
	}
}
usort($cumpleanos, function ($a, $b) { return $a['dia'] <=> $b['dia']; });
$edadPromedio = $conEdad ? round($sumaEdad / $conEdad) : null;
$totalSexo = $sexo['Mujeres'] + $sexo['Hombres'];

// Antigüedad del personal de planta
$antiguedad = array('Menos de 2' => 0, '2 a 4' => 0, '5 a 9' => 0, '10 a 19' => 0, '20 o más' => 0);
foreach ($plantaPorFunc as $p) {
	if (dash_fecha_valida($p['date_ent'])) {
		$a = dash_anios_desde($p['date_ent'], $corte);
		if ($a < 2) $antiguedad['Menos de 2']++;
		elseif ($a < 5) $antiguedad['2 a 4']++;
		elseif ($a < 10) $antiguedad['5 a 9']++;
		elseif ($a < 20) $antiguedad['10 a 19']++;
		else $antiguedad['20 o más']++;
	}
}

// Planta por Dirección General / Viceministerio (cargo más reciente)
$idPerActivos = array();
foreach ($plantaPorFunc as $p) {
	$idPerActivos[(int) $p['id_per']] = true;
}
$direcciones = array();
foreach (dash_filas($dashDb, "SELECT cp.id_per, cp.dir_g FROM char_per cp
	JOIN (SELECT id_per, MAX(id_char_per) m FROM char_per GROUP BY id_per) y ON y.m = cp.id_char_per") as $c) {
	if (!isset($idPerActivos[(int) $c['id_per']])) {
		continue;
	}
	$d = mb_strtoupper(trim(preg_replace('/\s+/', ' ', (string) $c['dir_g'])), 'UTF-8');
	$d = preg_replace(array('/^DIRECCI[OÓ]N GENERAL DE /u', '/^VICEMINISTERIO DE /u'), array('DG ', 'VM '), $d);
	$d = $d === '' ? 'Sin dato' : $d;
	$direcciones[$d] = ($direcciones[$d] ?? 0) + 1;
}
$direcciones = dash_top($direcciones, 8, 'Otras %d direcciones');

// Consultores por fuente de financiamiento (contrato vigente)
$idConActivos = array();
foreach ($consultores as $c) {
	$idConActivos[(int) $c['id_con']] = true;
}
$fuentes = array();
foreach (dash_filas($dashDb, "SELECT fc.id_con, fc.source_fin FROM fin_con fc
	JOIN (SELECT id_con, MAX(id_fin_con) m FROM fin_con GROUP BY id_con) y ON y.m = fc.id_fin_con") as $f) {
	if (!isset($idConActivos[(int) $f['id_con']])) {
		continue;
	}
	$fu = mb_strtoupper(trim(preg_replace('/\s+/', ' ', (string) $f['source_fin'])), 'UTF-8');
	$fu = preg_replace('/^TGN[\s-]*(\d+)$/', 'TGN-$1', $fu);
	$fu = $fu === '' ? 'Sin dato' : $fu;
	$fuentes[$fu] = ($fuentes[$fu] ?? 0) + 1;
}
$fuentes = dash_top($fuentes, 7, 'Otras %d fuentes');

// Ingresos y bajas de planta por año (últimos 10 años con datos)
$ingresosAnio = array();
foreach (dash_filas($dashDb, "SELECT YEAR(date_ent) a, COUNT(DISTINCT id_func) n FROM permanente
	WHERE date_ent > '1900-01-01' GROUP BY a") as $r) {
	$ingresosAnio[(int) $r['a']] = (int) $r['n'];
}
$bajasAnio = array();
foreach (dash_filas($dashDb, "SELECT YEAR(date_efect) a, COUNT(*) n FROM baja
	WHERE date_efect > '1900-01-01' GROUP BY a") as $r) {
	$bajasAnio[(int) $r['a']] = (int) $r['n'];
}
$anioFin = max(array_merge(array_keys($ingresosAnio), array_keys($bajasAnio), array(0)));
$anios = $anioFin ? range($anioFin - 9, $anioFin) : array();
$serieIngresos = array();
$serieBajas = array();
foreach ($anios as $a) {
	$serieIngresos[] = $ingresosAnio[$a] ?? 0;
	$serieBajas[] = $bajasAnio[$a] ?? 0;
}

// Nuevos ingresos: personas cuyo PRIMER ingreso (planta o contrato) cae en los 3 meses previos al corte
$inicioIngresos = date('Y-m-d', strtotime($corte . ' -3 months'));
$ingresosRecientes = array();
$ingresosTipo = array('Planta' => 0, 'Consultor' => 0);
foreach (dash_filas($dashDb, "SELECT z.id_func, z.primera, z.tipo, f.name, f.l_name1, f.l_name2,
		COALESCE(
			(SELECT cp.charge FROM permanente p JOIN char_per cp ON cp.id_per = p.id_per WHERE p.id_func = z.id_func ORDER BY cp.id_char_per DESC LIMIT 1),
			(SELECT cc.charge FROM contrato c JOIN char_con cc ON cc.id_con = c.id_con WHERE c.id_func = z.id_func ORDER BY cc.id_char_con DESC LIMIT 1)
		) cargo
	FROM (
		SELECT id_func, MIN(fe) primera, SUBSTRING_INDEX(GROUP_CONCAT(t ORDER BY fe), ',', 1) tipo FROM (
			SELECT id_func, date_ent fe, 'Planta' t FROM permanente WHERE date_ent > '1900-01-01'
			UNION ALL SELECT id_func, date_ent, 'Consultor' FROM contrato WHERE date_ent > '1900-01-01'
		) u GROUP BY id_func
	) z JOIN funcionario f ON f.id_func = z.id_func
	WHERE z.primera > '" . $inicioIngresos . "' AND z.primera <= '" . $corte . "'
	ORDER BY z.primera DESC") as $r) {
	$ingresosTipo[$r['tipo']] = ($ingresosTipo[$r['tipo']] ?? 0) + 1;
	$nombre = mb_convert_case(mb_strtolower(dash_txt($r['name'] . ' ' . $r['l_name1'] . ' ' . $r['l_name2']), 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
	$ingresosRecientes[] = array(
		'titulo' => $nombre,
		'detalle' => $r['tipo'] . ' · ' . dash_fecha($r['primera']) . ($r['cargo'] ? ' · ' . dash_txt($r['cargo']) : ''),
		'nombre' => $nombre, 'tipo' => $r['tipo'], 'fecha' => dash_fecha($r['primera']), 'cargo' => dash_txt($r['cargo']),
	);
}

// Posibles cargos acéfalos de planta: cargo + dirección cuyo último ocupante ya no está activo
// y que hoy nadie ocupa. La base no registra números de ítem, por eso se compara por nombre de cargo.
$acefalosPlanta = array();
foreach (dash_filas($dashDb, "SELECT UPPER(TRIM(cp.charge)) cargo, UPPER(TRIM(IFNULL(cp.dir_g, ''))) dir,
		MAX(p.id_per) ult_per, MAX(b.date_efect) baja
	FROM permanente p
	JOIN char_per cp ON cp.id_per = p.id_per
	JOIN (SELECT id_per, MAX(id_char_per) m FROM char_per GROUP BY id_per) y ON y.m = cp.id_char_per
	LEFT JOIN baja b ON b.id_per = p.id_per
	WHERE TRIM(IFNULL(cp.charge, '')) <> ''
	GROUP BY cargo, dir
	HAVING SUM(p.status = 1) = 0
	ORDER BY ult_per DESC") as $r) {
	$cargo = dash_txt($r['cargo']);
	if (!dash_cargo_valido($cargo)) {
		continue;
	}
	$dir = dash_txt($r['dir']);
	$dir = $dir === '' ? 'Sin dirección registrada' : preg_replace(array('/^DIRECCI[OÓ]N GENERAL DE /u', '/^VICEMINISTERIO DE /u'), array('DG ', 'VM '), $dir);
	$acefalosPlanta[] = array(
		'titulo' => $cargo,
		'detalle' => $dir . ' · ' . ($r['baja'] > '1900-01-01' ? 'baja ' . dash_fecha($r['baja']) : 'sin baja registrada'),
		'cargo' => $cargo, 'dir' => $dir, 'baja' => dash_fecha($r['baja']),
	);
}

// Consultorías concluidas en los últimos 6 meses sin un contrato vigente con el mismo cargo y dirección
$inicioConsultorias = date('Y-m-d', strtotime($corte . ' -6 months'));
$consultoriasSinReemplazo = array();
foreach (dash_filas($dashDb, "SELECT UPPER(TRIM(cc.charge)) cargo, UPPER(TRIM(IFNULL(cc.dir_g, ''))) dir,
		MAX(c.date_end) fin, SUM(c.status = 1) vigentes
	FROM contrato c
	JOIN char_con cc ON cc.id_con = c.id_con
	JOIN (SELECT id_con, MAX(id_char_con) m FROM char_con GROUP BY id_con) y ON y.m = cc.id_char_con
	WHERE TRIM(IFNULL(cc.charge, '')) <> ''
	GROUP BY cargo, dir
	HAVING vigentes = 0 AND fin > '" . $inicioConsultorias . "' AND fin <= '" . $corte . "'
	ORDER BY fin DESC") as $r) {
	$cargo = dash_txt($r['cargo']);
	if (!dash_cargo_valido($cargo)) {
		continue;
	}
	$dir = dash_txt($r['dir']);
	$dir = $dir === '' ? 'Sin dirección registrada' : preg_replace(array('/^DIRECCI[OÓ]N GENERAL DE /u', '/^VICEMINISTERIO DE /u'), array('DG ', 'VM '), $dir);
	$consultoriasSinReemplazo[] = array(
		'titulo' => $cargo,
		'detalle' => $dir . ' · concluyó ' . dash_fecha($r['fin']),
		'cargo' => $cargo, 'dir' => $dir, 'fin' => dash_fecha($r['fin']),
	);
}

mysqli_close($dashDb);

$meses = array(1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
$pctMujeres = dash_pct($sexo['Mujeres'], $totalSexo);
$pctHombres = $totalSexo ? 100 - $pctMujeres : 0;
?>
<style>
.dash-root {
	--surface-1: #fcfcfb;
	--page: #f9f9f7;
	--ink-1: #0b0b0b;
	--ink-2: #52514e;
	--ink-muted: #898781;
	--grid: #e1e0d9;
	--axis: #c3c2b7;
	--ring: rgba(11, 11, 11, 0.10);
	font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
	color: var(--ink-1);
	font-size: 13px;
	line-height: 1.4;
	text-align: left;
}
.dash-root * { box-sizing: border-box; }
/* Neutraliza las reglas generales del tema (.block_cont p, h3, ul) dentro del dashboard */
.block_cont .dash-root p { text-align: left; font-size: 12px; line-height: 1.4; padding: 0; margin: 0; }
.dash-head { display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 4px 16px; margin: 2px 0 14px; }
.dash-head h2 { font-size: 20px; font-weight: 600; margin: 0; color: var(--ink-1); }
.block_cont .dash-root .dash-head p { color: var(--ink-2); }
.dash-grid4 { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; margin-bottom: 12px; }
.dash-grid2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; margin-bottom: 12px; }
.dash-grid3 { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin-bottom: 12px; }
.dash-card-top { display: flex; align-items: baseline; justify-content: space-between; gap: 10px; }
.block_cont .dash-root p.dash-kpi-num.dash-kpi-md { font-size: 26px; margin: 4px 0 2px; }
.dash-list { list-style: none; margin: 8px 0 0; padding: 0; }
.dash-list li { display: block; margin: 0; padding: 6px 0; border-top: 1px solid var(--grid); background: none; min-width: 0; }
.dash-li-t { display: block; color: var(--ink-1); font-weight: 600; font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.dash-li-d { display: block; color: var(--ink-2); font-size: 11.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.dash-nota { color: var(--ink-muted); font-size: 11.5px; margin: 8px 0 0; }
.dash-card { background: var(--surface-1); border: 1px solid var(--ring); border-radius: 10px; padding: 14px 16px; min-width: 0; }
.dash-card h3 { font-size: 14px; font-weight: 600; margin: 0 0 2px; color: var(--ink-1); background: none; padding: 0; border: 0; text-shadow: none; text-transform: none; }
.block_cont .dash-root p.dash-sub { margin: 0 0 10px; color: var(--ink-2); }
.block_cont .dash-root p.dash-kpi-label { color: var(--ink-2); }
.block_cont .dash-root p.dash-kpi-num { font-size: 32px; font-weight: 600; line-height: 1.15; margin: 6px 0 4px; font-variant-numeric: tabular-nums; color: var(--ink-1); }
.dash-kpi-num small { font-size: 16px; font-weight: 500; color: var(--ink-2); }
.block_cont .dash-root p.dash-kpi-note { color: var(--ink-2); display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.dash-sw { display: inline-block; width: 10px; height: 10px; border-radius: 3px; flex: none; }
.dash-split { display: flex; gap: 2px; height: 12px; margin: 8px 0 8px; }
.dash-split span { display: block; height: 100%; }
.dash-split span:first-child { border-radius: 4px 0 0 4px; }
.dash-split span:last-child { border-radius: 0 4px 4px 0; }
.dash-legend { display: flex; flex-wrap: wrap; gap: 6px 16px; margin: 0; padding: 0; list-style: none; color: var(--ink-2); font-size: 12px; }
.dash-legend li { display: flex; align-items: center; gap: 6px; margin: 0; padding: 0; background: none; }
.dash-legend b { color: var(--ink-1); font-weight: 600; font-variant-numeric: tabular-nums; }
.dash-svg { width: 100%; height: auto; display: block; overflow: visible; }
.dash-svg text { font-family: inherit; }
.dash-grid { stroke: var(--grid); stroke-width: 1; }
.dash-axis { stroke: var(--axis); stroke-width: 1; }
.dash-tick { fill: var(--ink-muted); font-size: 11px; }
.dash-xlab { fill: var(--ink-2); font-size: 11.5px; }
.dash-val { fill: var(--ink-1); font-size: 12px; font-weight: 600; }
.dash-endlab { fill: var(--ink-1); font-size: 12px; font-weight: 600; }
.dash-hit { fill: transparent; }
.dash-col:hover .dash-hit, .dash-col:focus .dash-hit { fill: rgba(11, 11, 11, 0.04); }
.dash-col:focus, .dash-cross:focus, .dash-hrow:focus { outline: none; }
.dash-guide { stroke: var(--ink-muted); stroke-width: 1; stroke-dasharray: 3 3; opacity: 0; }
.dash-cross:hover .dash-guide, .dash-cross:focus .dash-guide { opacity: 1; }
.dash-line { fill: none; stroke-width: 2; stroke-linejoin: round; stroke-linecap: round; }
.dash-dot { stroke: var(--surface-1); stroke-width: 2; pointer-events: none; }
.dash-hbars { display: flex; flex-direction: column; gap: 6px; }
.dash-hrow { display: grid; grid-template-columns: minmax(0, 42%) 1fr 44px; align-items: center; gap: 10px; border-radius: 6px; padding: 2px 4px; margin: 0 -4px; }
.dash-hrow:hover, .dash-hrow:focus { background: rgba(11, 11, 11, 0.04); }
.dash-hlabel { color: var(--ink-2); font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.dash-htrack { display: block; height: 14px; }
.dash-hfill { display: block; height: 100%; border-radius: 0 4px 4px 0; min-width: 2px; }
.dash-hval { text-align: right; font-weight: 600; font-variant-numeric: tabular-nums; color: var(--ink-1); }
.dash-datos { margin-top: 10px; color: var(--ink-2); font-size: 12px; }
.dash-datos summary { cursor: pointer; color: var(--ink-2); }
.dash-datos table { border-collapse: collapse; width: 100%; margin-top: 6px; }
.dash-datos th, .dash-datos td { border-bottom: 1px solid var(--grid); padding: 4px 6px; text-align: left; font-size: 12px; background: none; color: var(--ink-1); }
.dash-datos th { color: var(--ink-2); font-weight: 600; }
.dash-datos .num { text-align: right; font-variant-numeric: tabular-nums; }
.dash-cumple { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 6px 16px; }
.dash-cumple li { display: flex; align-items: center; gap: 10px; margin: 0; padding: 4px 0; border-bottom: 1px solid var(--grid); background: none; min-width: 0; }
.dash-dia { flex: none; width: 34px; height: 34px; border-radius: 8px; background: #cde2fb; color: #104281; font-weight: 700; display: flex; align-items: center; justify-content: center; font-variant-numeric: tabular-nums; }
.dash-cumple .dash-nom { color: var(--ink-1); font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }
.dash-cumple .dash-det { color: var(--ink-2); font-size: 12px; display: block; }
.dash-vacio { color: var(--ink-2); margin: 6px 0; }
.dash-aviso { color: var(--ink-2); }
.dash-pie { color: var(--ink-muted); font-size: 11.5px; margin: 4px 0 0; }
.dash-tip { position: fixed; z-index: 1000; pointer-events: none; background: #0b0b0b; color: #fff; font: 12px/1.35 system-ui, -apple-system, "Segoe UI", sans-serif; padding: 6px 9px; border-radius: 6px; box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18); max-width: 320px; opacity: 0; transition: opacity .08s; }
.dash-tip.on { opacity: 1; }
@media (max-width: 860px) {
	.dash-grid4 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
	.dash-grid2, .dash-grid3, .dash-cumple { grid-template-columns: 1fr; }
}
</style>

<div class="dash-root">
	<div class="dash-head">
		<h2>Resumen del personal</h2>
		<p>Personal activo: planta con registro vigente y consultores con contrato vigente · Último movimiento registrado: <?php echo dash_e($fechaDatos); ?></p>
	</div>

	<div class="dash-grid4">
		<div class="dash-card">
			<p class="dash-kpi-label">Personal activo</p>
			<p class="dash-kpi-num"><?php echo dash_n($totalActivos); ?></p>
			<p class="dash-kpi-note">Planta y consultores</p>
		</div>
		<div class="dash-card">
			<p class="dash-kpi-label">Planta (ítem)</p>
			<p class="dash-kpi-num"><?php echo dash_n($totalPlanta); ?></p>
			<p class="dash-kpi-note"><span class="dash-sw" style="background:<?php echo $COLOR_PLANTA; ?>"></span><?php echo dash_pct($totalPlanta, $totalActivos); ?>% del personal activo</p>
		</div>
		<div class="dash-card">
			<p class="dash-kpi-label">Consultores</p>
			<p class="dash-kpi-num"><?php echo dash_n($totalConsultores); ?></p>
			<p class="dash-kpi-note"><span class="dash-sw" style="background:<?php echo $COLOR_CONSULTOR; ?>"></span><?php echo dash_pct($totalConsultores, $totalActivos); ?>% del personal activo</p>
		</div>
		<div class="dash-card">
			<p class="dash-kpi-label">Mujeres / hombres</p>
			<p class="dash-kpi-num"><?php echo $pctMujeres; ?>% <small>/ <?php echo $pctHombres; ?>%</small></p>
			<div class="dash-split" role="img" aria-label="Mujeres <?php echo dash_n($sexo['Mujeres']); ?>, hombres <?php echo dash_n($sexo['Hombres']); ?>">
				<?php if ($sexo['Mujeres']) { ?><span tabindex="0" data-tip="Mujeres: <?php echo dash_n($sexo['Mujeres']); ?> (<?php echo $pctMujeres; ?>%)" style="width:<?php echo $pctMujeres; ?>%;background:<?php echo $COLOR_MUJERES; ?>"></span><?php } ?>
				<?php if ($sexo['Hombres']) { ?><span tabindex="0" data-tip="Hombres: <?php echo dash_n($sexo['Hombres']); ?> (<?php echo $pctHombres; ?>%)" style="width:<?php echo $pctHombres; ?>%;background:<?php echo $COLOR_HOMBRES; ?>"></span><?php } ?>
			</div>
			<ul class="dash-legend">
				<li><span class="dash-sw" style="background:<?php echo $COLOR_MUJERES; ?>"></span>Mujeres <b><?php echo dash_n($sexo['Mujeres']); ?></b></li>
				<li><span class="dash-sw" style="background:<?php echo $COLOR_HOMBRES; ?>"></span>Hombres <b><?php echo dash_n($sexo['Hombres']); ?></b></li>
				<?php if ($sinSexo) { ?><li>Sin dato <b><?php echo dash_n($sinSexo); ?></b></li><?php } ?>
			</ul>
		</div>
	</div>

	<div class="dash-grid3">
		<div class="dash-card">
			<h3>Nuevos ingresos · últimos 3 meses</h3>
			<p class="dash-sub"><?php echo dash_fecha($inicioIngresos); ?> al <?php echo dash_e($fechaDatos); ?> · personas que ingresan por primera vez</p>
			<p class="dash-kpi-num dash-kpi-md"><?php echo dash_n(count($ingresosRecientes)); ?></p>
			<ul class="dash-legend">
				<li><span class="dash-sw" style="background:<?php echo $COLOR_PLANTA; ?>"></span>Planta <b><?php echo dash_n($ingresosTipo['Planta']); ?></b></li>
				<li><span class="dash-sw" style="background:<?php echo $COLOR_CONSULTOR; ?>"></span>Consultores <b><?php echo dash_n($ingresosTipo['Consultor']); ?></b></li>
			</ul>
			<?php if ($ingresosRecientes) { ?>
				<?php echo dash_lista($ingresosRecientes, 5); ?>
				<details class="dash-datos"><summary>Ver los <?php echo count($ingresosRecientes); ?> ingresos</summary><table><thead><tr><th>Nombre</th><th>Tipo</th><th>Ingreso</th><th>Cargo</th></tr></thead><tbody>
					<?php foreach ($ingresosRecientes as $r) { ?><tr><td><?php echo dash_e($r['nombre']); ?></td><td><?php echo $r['tipo']; ?></td><td><?php echo $r['fecha']; ?></td><td><?php echo dash_e($r['cargo']); ?></td></tr><?php } ?>
				</tbody></table></details>
			<?php } else { ?><p class="dash-vacio">Sin ingresos en el periodo.</p><?php } ?>
		</div>

		<div class="dash-card">
			<h3>Posibles cargos acéfalos · planta (TGN)</h3>
			<p class="dash-sub">Cargos cuyo último ocupante ya no está activo y que nadie ocupa hoy</p>
			<p class="dash-kpi-num dash-kpi-md"><?php echo dash_n(count($acefalosPlanta)); ?></p>
			<?php if ($acefalosPlanta) { ?>
				<?php echo dash_lista($acefalosPlanta, 5); ?>
				<details class="dash-datos"><summary>Ver los <?php echo count($acefalosPlanta); ?> cargos</summary><table><thead><tr><th>Cargo</th><th>Dirección</th><th>Baja</th></tr></thead><tbody>
					<?php foreach ($acefalosPlanta as $r) { ?><tr><td><?php echo dash_e($r['cargo']); ?></td><td><?php echo dash_e($r['dir']); ?></td><td><?php echo $r['baja']; ?></td></tr><?php } ?>
				</tbody></table></details>
			<?php } else { ?><p class="dash-vacio">No se detectaron cargos acéfalos.</p><?php } ?>
		</div>

		<div class="dash-card">
			<h3>Consultorías concluidas sin reemplazo</h3>
			<p class="dash-sub"><?php echo dash_fecha($inicioConsultorias); ?> al <?php echo dash_e($fechaDatos); ?> · sin contrato vigente para el mismo cargo</p>
			<p class="dash-kpi-num dash-kpi-md"><?php echo dash_n(count($consultoriasSinReemplazo)); ?></p>
			<?php if ($consultoriasSinReemplazo) { ?>
				<?php echo dash_lista($consultoriasSinReemplazo, 5); ?>
				<details class="dash-datos"><summary>Ver las <?php echo count($consultoriasSinReemplazo); ?> consultorías</summary><table><thead><tr><th>Cargo</th><th>Dirección</th><th>Concluyó</th></tr></thead><tbody>
					<?php foreach ($consultoriasSinReemplazo as $r) { ?><tr><td><?php echo dash_e($r['cargo']); ?></td><td><?php echo dash_e($r['dir']); ?></td><td><?php echo $r['fin']; ?></td></tr><?php } ?>
				</tbody></table></details>
			<?php } else { ?><p class="dash-vacio">No hay consultorías concluidas sin reemplazo.</p><?php } ?>
		</div>
	</div>
	<p class="dash-nota" style="margin:-4px 0 12px">Cargos acéfalos: estimación. La base no registra números de ítem; se compara por nombre de cargo y dirección del registro más reciente.</p>

	<div class="dash-grid2">
		<div class="dash-card">
			<h3>Distribución por edad</h3>
			<p class="dash-sub">Personal activo, a la fecha de corte · edad promedio <b><?php echo $edadPromedio !== null ? $edadPromedio . ' años' : '—'; ?></b> (<?php echo dash_n($conEdad); ?> con fecha de nacimiento)</p>
			<?php echo dash_columnas($edades, $COLOR_PLANTA, 'personas'); ?>
			<?php echo dash_tabla($edades, 'Rango de edad', 'Personas'); ?>
		</div>
		<div class="dash-card">
			<h3>Antigüedad del personal de planta</h3>
			<p class="dash-sub">Años desde el ingreso registrado, a la fecha de corte</p>
			<?php echo dash_columnas($antiguedad, $COLOR_PLANTA, 'personas'); ?>
			<?php echo dash_tabla($antiguedad, 'Años de antigüedad', 'Personas'); ?>
		</div>
	</div>

	<div class="dash-grid2">
		<div class="dash-card">
			<h3>Planta por Dirección General</h3>
			<p class="dash-sub">Según el cargo más reciente · DG = Dirección General, VM = Viceministerio</p>
			<?php echo $direcciones ? dash_barras_h($direcciones, $COLOR_PLANTA, 'personas') : '<p class="dash-vacio">Sin datos de cargo.</p>'; ?>
			<?php echo dash_tabla($direcciones, 'Dirección', 'Personas'); ?>
		</div>
		<div class="dash-card">
			<h3>Consultores por fuente de financiamiento</h3>
			<p class="dash-sub">Contrato vigente</p>
			<?php echo $fuentes ? dash_barras_h($fuentes, $COLOR_CONSULTOR, 'consultores') : '<p class="dash-vacio">Sin datos de financiamiento.</p>'; ?>
			<?php echo dash_tabla($fuentes, 'Fuente', 'Consultores'); ?>
		</div>
	</div>

	<?php if ($anios) { ?>
	<div class="dash-card" style="margin-bottom:12px">
		<h3>Ingresos y bajas de personal de planta por año</h3>
		<p class="dash-sub">Últimos 10 años con registros</p>
		<ul class="dash-legend" style="margin-bottom:6px">
			<li><span class="dash-sw" style="background:<?php echo $COLOR_PLANTA; ?>"></span>Ingresos</li>
			<li><span class="dash-sw" style="background:<?php echo $COLOR_BAJAS; ?>"></span>Bajas</li>
		</ul>
		<?php echo dash_lineas($anios, array(
			array('nombre' => 'Ingresos', 'valores' => $serieIngresos, 'color' => $COLOR_PLANTA),
			array('nombre' => 'Bajas', 'valores' => $serieBajas, 'color' => $COLOR_BAJAS),
		), 'personas'); ?>
		<details class="dash-datos"><summary>Ver datos</summary><table><thead><tr><th>Año</th><th class="num">Ingresos</th><th class="num">Bajas</th></tr></thead><tbody>
			<?php foreach ($anios as $i => $a) { ?><tr><td><?php echo $a; ?></td><td class="num"><?php echo dash_n($serieIngresos[$i]); ?></td><td class="num"><?php echo dash_n($serieBajas[$i]); ?></td></tr><?php } ?>
		</tbody></table></details>
	</div>
	<?php } ?>

	<div class="dash-card" style="margin-bottom:12px">
		<h3>Cumpleaños de <?php echo $meses[$mesActual]; ?></h3>
		<p class="dash-sub"><?php echo count($cumpleanos) ? dash_n(count($cumpleanos)) . ' personas del personal activo' : 'Sin cumpleaños registrados este mes'; ?></p>
		<?php if ($cumpleanos) { ?>
		<ul class="dash-cumple">
			<?php foreach (array_slice($cumpleanos, 0, 12) as $c) { ?>
			<li><span class="dash-dia"><?php echo $c['dia']; ?></span><span style="min-width:0"><span class="dash-nom" title="<?php echo dash_e($c['nombre']); ?>"><?php echo dash_e(mb_convert_case(mb_strtolower($c['nombre'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8')); ?></span><span class="dash-det"><?php echo $c['tipo']; ?> · cumple <?php echo $c['cumple']; ?></span></span></li>
			<?php } ?>
		</ul>
		<?php if (count($cumpleanos) > 12) { ?>
		<details class="dash-datos"><summary>Ver los <?php echo count($cumpleanos); ?> cumpleaños del mes</summary><table><thead><tr><th>Día</th><th>Nombre</th><th>Tipo</th><th class="num">Cumple</th></tr></thead><tbody>
			<?php foreach ($cumpleanos as $c) { ?><tr><td><?php echo $c['dia']; ?></td><td><?php echo dash_e($c['nombre']); ?></td><td><?php echo $c['tipo']; ?></td><td class="num"><?php echo $c['cumple']; ?></td></tr><?php } ?>
		</tbody></table></details>
		<?php } ?>
		<?php } ?>
	</div>
</div>

<div class="dash-tip" id="dashTip" role="tooltip"></div>
<script>
(function () {
	var tip = document.getElementById('dashTip');
	if (!tip) return;
	function mostrar(el, x, y) {
		tip.textContent = el.getAttribute('data-tip');
		tip.classList.add('on');
		var w = tip.offsetWidth, h = tip.offsetHeight;
		var left = Math.min(x + 14, window.innerWidth - w - 8);
		var top = y - h - 12 < 8 ? y + 16 : y - h - 12;
		tip.style.left = left + 'px';
		tip.style.top = top + 'px';
	}
	function objetivo(e) {
		var t = e.target;
		while (t && t !== document && !(t.getAttribute && t.getAttribute('data-tip'))) t = t.parentNode;
		return t && t !== document ? t : null;
	}
	document.addEventListener('mousemove', function (e) {
		var el = objetivo(e);
		if (el && el.closest && el.closest('.dash-root')) mostrar(el, e.clientX, e.clientY);
		else tip.classList.remove('on');
	});
	document.addEventListener('focusin', function (e) {
		var el = objetivo(e);
		if (el && el.closest && el.closest('.dash-root')) {
			var r = el.getBoundingClientRect();
			mostrar(el, r.left + r.width / 2, r.top);
		}
	});
	document.addEventListener('focusout', function () { tip.classList.remove('on'); });
})();
</script>
