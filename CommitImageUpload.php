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
        $myBlobEnc = cryptfile($myBlob, MainKey);

       	echo "$fn uploaded";
        if(strpos($fn,".mp4")>0){
           //generate thumbnail from video
           file_put_contents('./img/'.$myDir.'/slide/'.$newname, $myBlob );
           echo '<object data="./thumbfromvideo.php?filename=./img/'.$myDir.'/slide/'.$newname.'&thumbpath=./img/'.$myDir.'/thumb"></object>';
        }elseif(strpos($fn,".mp3")>0){
           //use audio icon for thumbnail
           file_put_contents('./img/'.$myDir.'/slide/'.$newname, $myBlob );
           echo '<img src="./img/Backgrounds/audioicon.jpg">';
           copy("./img/Backgrounds/audioicon.jpg", "./img/".$myDir."/thumb/".$newname.".jpg");
        }else{
           //generate image for slideshow
           file_put_contents('./img/'.$myDir.'/'.$newname, $myBlobEnc );
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
			$fn = $files['name'][$id];
   		$newname = cryptfilename($fn);
      $myBlob = file_get_contents($files['tmp_name'][$id]);
      $myBlobEnc = cryptfile($myBlob, MainKey);
      echo "<p>File $fn uploaded.</p>";
      if(strpos($fn,".mp4")>0){
           //generate thumbnail from video
           file_put_contents('./img/'.$myDir.'/slide/'.$newname, $myBlobEnc );
           $htmlString += '<object data="./thumbfromvideo.php?filename=./img/'.$myDir.'/slide/'.$newname.'&thumbpath=./img/'.$myDir.'/thumb"></object>';
        }elseif(strpos($fn,".mp3")>0){
           //use audio icon for thumbnail
           file_put_contents('./img/'.$myDir.'/slide/'.$newname, $myBlob );
           $htmlString += '<img src="./img/Backgrounds/audioicon.jpg">';
           copy("./img/Backgrounds/audioicon.jpg", "./img/".$myDir."/thumb/".$newname.".jpg");
        }else{
           //generate image for slideshow
           file_put_contents('./img/'.$myDir.'/'.$newname, $myBlobEnc );
           $htmlString += '<img src="image.php?image_name='.$newname.'&style=slide&image_path=img/'.$myDir.'" >';
       	}
		}
	}
 echo $htmlString ;
}
?>