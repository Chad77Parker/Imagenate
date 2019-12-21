<?php
include 'ccrypt.php';

/*
Server-side PHP file upload code for HTML5 File Drag & Drop demonstration

*/

$fn = (isset($_FILES['photos']['name'][0])?$_FILES['photos']['name'][0]:false);
if($_POST['NewUploadFolder']!= "New upload folder" && $_POST['NewUploadFolder']!=""){
  $myDir=cryptfilename($_POST['NewUploadFolder']);
  if(!is_dir('./img/'.$myDir)){
    mkdir('./img/'.$myDir);
    mkdir('./img/'.$myDir.'/thumb');
    mkdir('./img/'.$myDir.'/slide');
  }
}else{
  $myDir= $_POST['mySelect'];
}
if ($fn) {
  	// AJAX call
        $newname = cryptfilename($fn);
        $myBlob = file_get_contents($_FILES['photos']['tmp_name'][0]);
        $myBlob = cryptfile($myBlob, MainKey);

       	echo "$fn uploaded";
        if(strpos($fn,".mp4")>0){
           //generate thumbnail from video
           file_put_contents('./img/'.$myDir.'/slide/'.$newname, $myBlob );
           echo '<img src="./img/Backgrounds/movieicon.jpg">';
           copy("./img/Backgrounds/movieicon.jpg", "./img/".$myDir."/thumb/".$newname.".jpg");
        }elseif(strpos($fn,".mp3")>0){
           file_put_contents('./img/'.$myDir.'/slide/'.$newname, $myBlob );
           echo '<img src="./img/Backgrounds/audioicon.jpg">';
           copy("./img/Backgrounds/audioicon.jpg", "./img/".$myDir."/thumb/".$newname.".jpg");
        }else{
           //generate image for slideshow
           file_put_contents('./img/'.$myDir.'/'.$newname, $myBlob );
           echo '<img src="image.php?image_name='.$newname.'&style=slide&image_path=img/'.$myDir.'" >';
       	}
        exit();

}
else {
  // form submit
	$files = $_FILES['userfile'];
 $htmlString ='';
  foreach ($files['error'] as $id => $err) {
		if ($err == UPLOAD_ERR_OK) {
			$namefile = $files['name'][$id];
   		$newname = cryptfilename($namefile);
      $myBlob = file_get_contents($files['tmp_name'][$id]);
      $myBlob = cryptfile($myBlob, MainKey);
      echo "<p>File $namefile uploaded.</p>";
      if(strpos($fn,".mp4")>0){
           //generate thumbnail from video
           file_put_contents('./img/'.$myDir.'/slide/'.$newname, $myBlob );
           $htmlString += '<img src="./img/Backgrounds/movieicon.jpg">';
           copy("./img/Backgrounds/movieicon.jpg", "./img/".$myDir."/thumb/".$newname.".jpg");
        }elseif(strpos($fn,".mp3")>0){
           file_put_contents('./img/'.$myDir.'/slide/'.$newname, $myBlob );
           $htmlString += '<img src="./img/Backgrounds/audioicon.jpg">';
           copy("./img/Backgrounds/audioicon.jpg", "./img/".$myDir."/thumb/".$newname.".jpg");
        }else{
           //generate image for slideshow
           file_put_contents('./img/'.$myDir.'/'.$newname, $myBlob );
           $htmlString += '<img src="image.php?image_name='.$newname.'&style=slide&image_path=img/'.$myDir.'" >';
       	}
		}
	}
 echo $htmlString ;
}
?>