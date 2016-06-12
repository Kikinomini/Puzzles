<?php
$testGD = get_extension_funcs("gd"); // Grab function list
if (!$testGD){ echo "GD not even installed. Please install GD"; exit; }
header("Content-type: image/png");

$x = 120;
$y = 60;

$text =  isset($_GET["t"])?$_GET["t"]:"article";


$picture = imagecreatetruecolor($x, $y);
$green = imagecolorallocate($picture, 0, 255, 0);
imagecolorallocate($picture, 150, 150, 0);

imagestring($picture,5, $x/10, $y/2,$text, $green);

imagepng($picture);
imagedestroy($picture);
?>