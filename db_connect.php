<?php
/* Database connection start */
$servername = "172.16.0.60";
$username = "registro";
$password = "Roacorp";
$dbname = "registrorrhh";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>