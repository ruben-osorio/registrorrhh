<?
$fecha_ini="10-04-2012";
$fecha_fin="14-04-2012";

function diasEntreFechas($fechainicio, $fechafin)
{
    return ((strtotime($fechafin)-strtotime($fechainicio))/86400);
}
echo $fecha_ini." ".$fecha_fin." Total dias: ".diasEntreFechas($fecha_ini,$fecha_fin);

function horasEntreHoras($horainicio, $horafin)
{
	$dif=date("H:i:s", strtotime("00:00:00") + strtotime($horafin) - strtotime($horainicio) );
  	return $dif;
}
echo "<br>";
echo "08:30 -"."18:30"." Total horas ".horasEntreHoras("08:30","18:30");

function contarDiasFinde()
//function contarNoFinde($fechaInicio,$fechaFin)
{
	$fecha1 = strtotime('2012-08-03'); 
	$fecha2 = strtotime('2012-09-30'); 
	echo "<br />";	
	$c=0;
	for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1)))
	{ 
	
		if((strcmp(date('D',$fecha1),'Sun')==0) || (strcmp(date('D',$fecha1),'Sat')==0))
		{
			echo date('Y-m-d D',$fecha1) . '<br />'; 
			 //echo sumasdiasemana (date('Y-m-d',$fecha1)). '<br />'; 	
			 $c++;
		}
	} 
	echo "total findes: ".$c;
}//fin de domingos
echo "<br />".contarDiasFinde();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
</body>
</html>
