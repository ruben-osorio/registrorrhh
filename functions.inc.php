<?

function cambia_formato_dias($numero)
{
	$partes = explode(".",$numero); 
	if ($partes[1] == 0) 
	{ 
		$result=$partes[0]; 
	} 
	else
	{
		$result=$partes[0]." 1/2";
	}	
	return($result);
}

function cambia_dateN_to_dateMy($fecha)
{
	$fecha = explode("/", $fecha);
	$dia = $fecha[0];
	$mes = $fecha[1];
	$anno = $fecha[2];
	return($anno."-".$mes."-".$dia);
}

function cambia_dateN_to_dateMy_1($fecha)
{
	$fecha = explode("-", $fecha);
	$dia = $fecha[0];
	$mes = $fecha[1];
	$anno = $fecha[2];
	return($anno."-".$mes."-".$dia);
}

function cambia_dateMy_to_dateN($fecha)
{
	$fecha = explode("-", $fecha);
	$dia = $fecha[0];
	$mes = $fecha[1];
	$anno = $fecha[2];
	return($anno."-".$mes."-".$dia);
}

function diasEntreFechas($fechainicio, $fechafin)
{
    return ((strtotime($fechafin)-strtotime($fechainicio))/86400);
}

function horasEntreHoras($horainicio, $horafin)
{
	$dif=date("H:i:s", strtotime("00:00:00") + strtotime($horafin) - strtotime($horainicio) );
  	return ($dif);
}

function contarDiasFinde($fecha1,$fecha2)
{
	$fecha1 = strtotime($fecha1); 
	$fecha2 = strtotime($fecha2); 
	$c=0;
	for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1)))
	{ 
	
		if((strcmp(date('D',$fecha1),'Sun')==0) || (strcmp(date('D',$fecha1),'Sat')==0))
		{
			//echo date('Y-m-d D',$fecha1) . '<br />'; 			 
			 $c++;
		}
	} 
	return ($c);
}

function encode_007($string,$key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string,$i,1));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
    }
    return $hash;
}

function decode_007($string,$key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i+=2) {
        $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}
?>