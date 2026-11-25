<?php
// JQuery File Upload Plugin v1.4.1 by RonnieSan - (C)2009 Ronnie Garcia

if (isset($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_GET['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	$extension=explode(".",$_FILES['Filedata']['name']);
	
	// Uncomment the following line if you want to make the directory if it doesn't exist
	// mkdir(str_replace('//','/',$targetPath), 0755, true);
	$_FILES['Filedata']['name'];
	move_uploaded_file($tempFile,$targetFile);
	$total_imagenes = count(glob($_GET['folder']."/{*.jpg,*.gif,*.png}",GLOB_BRACE))+1;
	
	rename($targetFile,$targetPath."new_name_".$total_imagenes.".".$extension[1]); 
	
	
}	
echo '1';

?>