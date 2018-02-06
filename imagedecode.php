<?php
include 'Ccrypt.php';
$filename = $_GET['filename'];
$myblobi = file_get_contents($filename);
$myblobi = cryptfile($myblobi,MainKey);
header('Content-Type: image/jpg');
$im = imagecreatefromstring($myblobi);
imagejpeg($im,NULL,100);
imagedestroy($im);
?>