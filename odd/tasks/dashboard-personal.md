# Dashboard de personal para administradores

## Objetivo
Pantalla de inicio del administrador (`permisos = 0`) con los indicadores más relevantes del personal.

## Alcance
- `DashboardPersonal.php`: consultas + render (HTML/CSS + SVG en servidor, JS mínimo para tooltips).
- `index.php`: dashboard como inicio del admin y ruta `?selected=Dashboard`; `break` faltante en el case '0'.
- `adminNavigation.php`: enlace "Inicio".

## Definiciones
- Planta activa: `permanente.status = 1` (registro más reciente por funcionario).
- Consultor activo: `contrato.status = 1` (más reciente), excluyendo a quien ya es planta activa.
- Edad y antigüedad se calculan a la fecha actual; se muestra la fecha del último movimiento registrado.

## Paleta (validada con dataviz/scripts/validate_palette.js, modo claro)
- Planta `#2a78d6` / Consultores `#eb6834`: PASS.
- Mujeres `#1baf7a` / Hombres `#6250d6`: PASS con WARN de contraste (aqua 2.74:1) → etiquetas visibles + tabla.
- Ingresos `#2a78d6` / Bajas `#e34948`: PASS.

## TDD
Desactivado. Verificación: lint PHP 8.4 + carga HTTP como admin (base local y base consolidada) + revisión visual.

## Tareas
- [x] D1 `DashboardPersonal.php` (indicadores, edad, antigüedad, direcciones, fuentes, ingresos/bajas, cumpleaños)
- [x] D2 Integración en `index.php` (inicio admin + `?selected=Dashboard`, `break` agregado) y menú "Inicio"
- [x] D3 Verificación: lint PHP 8.4 OK; admin carga sin errores con base consolidada (834 activos)
      y con `rrhh` local (583); usuario rol 1 no ve el dashboard; captura revisada (sin solapamientos)

## Notas
- Datos registrados hasta 20/04/2018: la antigüedad "menos de 2" y "2 a 4" sale en 0 porque se calcula a hoy.
- Sin modo oscuro: el tema de la aplicación es solo claro.
