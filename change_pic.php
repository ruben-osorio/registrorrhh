<?php

ini_set ('gd.jpeg_ignore_warning', 1);
/* Get post details */
$post = isset($_POST) ? $_POST: array();
switch($post['action']) {
	case 'save' :

	saveProfilePic();
	saveProfilePicTmp();
	break;
	default:
	changeProfilePic();




}
/* Function to change profile picture */
function changeProfilePic() {

	$post = isset($_POST) ? $_POST: array();
	$max_width = "500"; 
	//$userId = isset($post['ci']) ? intval($post['ci']) : 0;
    $userId = isset($post['ci']) ? $post['ci'] : 0;
	$path = 'images/tmp';
	$valid_formats = array("jpg", "png", "gif", "jpeg");
	$name = $_FILES['profile-pic']['name'];
	$size = $_FILES['profile-pic']['size'];
	if(strlen($name)) {
		list($txt, $ext) = explode(".", $name);
		if(in_array($ext,$valid_formats)) {
			if($size<(2048*2048)) {
				$actual_image_name = 'avatar' .'_'.$userId .'.'.$ext;
				$filePath = $path .'/'.$actual_image_name;
				$tmp = $_FILES['profile-pic']['tmp_name'];
				if(move_uploaded_file($tmp, $filePath)) {
					$width = getWidth($filePath);
					$height = getHeight($filePath);
					//Scale the image if it is greater than the width set above
					if ($width > $max_width){
						$scale = $max_width/$width;
						$uploaded = resizeImage($filePath,$width,$height,$scale, $ext);
					} else {
						$scale = 1;
						$uploaded = resizeImage($filePath,$width,$height,$scale, $ext);
					}					
					echo "<img id='photo' file-name='".$actual_image_name."' class='' src='".$filePath.'?'.time()."' class='preview'/>";
				}
				else
				echo "falla";
			}
			else
			echo "el peso de la imagen debe ser menor a 2 MB";
		}
		else
		echo "Formato de archivo invalido, debe utilizar un archivo de imagen..";
	}
	else
	echo "Por favor seleccione la imagen..!";
	exit;
}
/* Function to handle save profile pic */
function saveProfilePic()
{
	include_once("db_connect.php");
	$post = isset($_POST) ? $_POST: array();
    $idfunc = $post['id_func'];
	//Handle profile picture update with MySQL update Query using $options array	
	if($idfunc )
	{

		$sql_query = "SELECT * FROM funcionario WHERE id_func = ". $idfunc;
		$resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));		
		if(mysqli_num_rows($resultset)) {                     

			$sql_update = "UPDATE funcionario set foto ='".mysqli_escape_string($conn,$post['image_name'])."' WHERE id_func = ". $idfunc;
			//echo $sql_update;
			mysqli_query($conn, $sql_update) or die("database error:". mysqli_error($conn));
		}
	}
}
	
/* Function to update image */
 function saveProfilePicTmp() {
	$post = isset($_POST) ? $_POST: array();
	$userId = isset($post['id']) ? intval($post['id']) : 0;
	$path ='\\images\\tmp';
	$t_width = 300; // Maximum thumbnail width
	$t_height = 300;    // Maximum thumbnail height	
	if(isset($_POST['t']) and $_POST['t'] == "ajax") {
		extract($_POST);		
		$imagePath = 'images/tmp/'.$_POST['image_name'];
		$ratio = ($t_width/$w1); 
		$nw = ceil($w1 * $ratio);
		$nh = ceil($h1 * $ratio);
		$nimg = imagecreatetruecolor($nw,$nh);
		$im_src = imagecreatefromjpeg($imagePath);
		imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w1,$h1);
		imagejpeg($nimg,$imagePath,90);		
	}
	echo $imagePath.'?'.time();;
	exit(0);    
}    
/* Function  to resize image */
function resizeImage($image,$width,$height,$scale, $ext) {
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch ($ext) {
        case 'jpg':
        case 'jpeg':
            $source = imagecreatefromjpeg($image);
            break;
        case 'gif':
            $source = imagecreatefromgif($image);
            break;
        case 'png':
            $source = imagecreatefrompng($image);
            break;
        default:
            $source = false;
            break;
    }	
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$image,90);
	chmod($image, 0777);
	return $image;
}
/*  Function to get image height. */
function getHeight($image) {
    $sizes = getimagesize($image);
    $height = $sizes[1];
    return $height;
}
/* Function to get image width */
function getWidth($image) {
    $sizes = getimagesize($image);
    $width = $sizes[0];
    return $width;
}
?>
