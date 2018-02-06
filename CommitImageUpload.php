<?php

include 'ccrypt.php';

/*
Server-side PHP file upload code for HTML5 File Drag & Drop demonstration
Featured on SitePoint.com
Developed by Craig Buckler (@craigbuckler) of OptimalWorks.net
*/

$fn = (isset($_FILES['photos']['name'][0])?$_FILES['photos']['name'][0]:false);
if($_POST['NewUploadFolder']!= "New upload folder" && $_POST['NewUploadFolder']!=""){
  $myDir=cryptfilename($_POST['NewUploadFolder']);
  if(!is_dir('./img/'.$myDir)){
    mkdir('./img/'.$myDir);
    mkdir('./img/'.$myDir.'/thumb');
  }
}else{
  $myDir= $_POST['mySelect'];
}
if ($fn) {
  	// AJAX call
  			$newname = cryptfilename($fn);
        $myBlob = file_get_contents($_FILES['photos']['tmp_name'][0]);
        $myBlob = cryptfile($myBlob, MainKey);
        file_put_contents('./img/'.$myDir.'/'.$newname, $myBlob );
       	echo "$fn uploaded";
        exit();

}
else {
  // form submit
	$files = $_FILES['userfile'];
  foreach ($files['error'] as $id => $err) {
		if ($err == UPLOAD_ERR_OK) {
			$namefile = $files['name'][$id];
   		$newname = cryptfilename($namefile);
      $myBlob = file_get_contents($files['tmp_name'][$id]);
      $myBlob = cryptfile($myBlob, MainKey);
      file_put_contents('./img/'.$myDir.'/'.$newname, $myBlob );
   		echo "<p>File $namefile uploaded.</p>";
		}
	}

}
?>