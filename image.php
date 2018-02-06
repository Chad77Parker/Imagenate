<?PHP
include "ccrypt.php";
$image_name = $_GET['image_name'];
$image_path = $_GET['image_path'];
$style = $_GET['style'];
     // Now set the maximum sizes to the different styles.
     // You may set additional styles, but remember to
     // create the according subfolders.
switch($style) {
  case "show":
    $max_size = 800;
    break;
  case "thumb":
    $max_size = 250;
}
$dest_file = "$image_path/$style/$image_name";
     // set output file
$image_file = "$image_path/$image_name";
     // set source file
$myblobi = file_get_contents($image_file);
$myblobi = cryptfile($myblobi,MainKey);
$size = getimagesizefromstring($myblobi);
     // get original size
if($size[0] > $size[1]) {
  $divisor = $size[0] / $max_size;
}
else {
  $divisor = $size[1] / $max_size;
}
     // to get allways pictures of the same size, which ist
     // mostly wanted in imageviewers, look what ist larger:
     // width or height
$new_width = $size[0] / $divisor;
$new_height = $size[1] / $divisor;
     // set new sizes
settype($new_width, 'integer');
settype($new_height, 'integer');
     // sizes should be integers
$image_big = imagecreatefromstring($myblobi);
     // load original image
$image_small = imagecreatetruecolor($new_width, $new_height);
     // create new image
imagecopyresampled($image_small, $image_big, 0,0, 0,0, $new_width,$new_height, $size[0],$size[1]);
     // imageresampled whill result in a much higher quality
     // than imageresized
imagedestroy($image_big);
     // the original data are no longer used
header('Content-Type: image/jpg');
if($style=="show" || $style=="thumb") {
  if (!is_dir($image_path.'/'.$style)){
    mkdir($image_path.'/'.$style);
  }
  if(!file_exists($dest_file))
  // start buffering
ob_start();
imagejpeg($image_small);
$contents =  ob_get_contents();
ob_end_clean();
$myblobi = cryptfile($contents, MainKey);
file_put_contents($dest_file, $myblobi);

   // imagejpeg($image_small, $dest_file, 100);
}
     // if you have set additional sizese put them in the
     // if-arguments, too.
     // if someone calls the image.php directly in the
     // browser with imagenames allready existing, they
     // won't be overwritten
imagejpeg($image_small, NULL, 100);
imagedestroy($image_small);
     // finally send image to browser and destroy no longer
     // needed data.
?>