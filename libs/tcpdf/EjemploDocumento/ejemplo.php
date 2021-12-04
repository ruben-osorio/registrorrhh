<?php 
/* En los encabezados indicamos que se trata de un documento de MS-WORD
  y en el nombre de archivo le ponemos la extensión RTF.            */
header('Content-type: application/msword');
header('Content-Disposition: inline; filename=ejemplo.rtf'); 

$var = '<b>Hola mundo</b>';
$prueba= "{\\fs30 El navegador Número 1}";

/*  Comenzamos a armar el documento  */
$output="{\\rtf1";   //<-- Iniciamos un documento RTF

$output.= "{\\fs48 Internet Explorer 7}"; //<-- Texto de tamaño 48 para el Título
//$output.= "$var";

$output.= "\\par ";  //<-- ENTER       

$output.= "{\\fs30 El navegador Número 1}"; //<-- Texto de tamaño 30 para el Subtítulo
$output.= "\\par ";  //<-- ENTER       
$output.= "\\par ";  //<-- ENTER       

/* Parrafo */
$output.= "Windows Internet Explorer (también conocido antes como Internet Explorer, IE o MSIE) 
es un navegador de Internet producido por Microsoft para su plataforma 
Windows y más tarde para Apple Macintosh. ";
$output.= "\\par ";  //<-- ENTER       

/* Parrafo */
$output.= "El 18 de octubre de 2006, Microsoft lanzó la versión 
número 7 de Internet Explorer. Entre otros detalles el programa fue 
renombrado a Windows Internet Explorer, como muestra de 
la integración de la aplicación con el Sistema Operativo. 
IE7 esta disponible solamente para Windows XP Service Pack 2, 
Windows Server 2003 Service Pack 1 y ";
$output.= "{\\b Windows Vista}."; //<-- Poner negritas

$output.= "\\par ";  //<-- ENTER
$output.= "\\par ";  //<-- ENTER
$output.= "{\\qr Tomado de wikipedia\\par}"; // <-- Alineado a la derecha

$output.= "{\\i Bill Gates III}"; // <-- Itálica
$output.= "\\par ";  //<-- ENTER
$output.= "{\\ul Fundador de Microsoft}"; // <-- Subrayado

$output.="}"; //<-- Terminador del RTF

/*  Enviamos el documento completo a la salida  */
//echo $output; 
?>