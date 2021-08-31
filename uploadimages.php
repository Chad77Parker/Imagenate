<?php
include "Access.php";

?>
<html>
<head>
<title>Imagenate</title>
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="./data/UploadImages.css" />
</head>

<body>
<div id="Title">
Image Upload
</div>

<div id="background"></div>

<div id="controls">
<input type="button" value="Return Home" onclick="document.forms[1].submit();"> <br>
<!-- The data encoding type, enctype, MUST be specified as below -->
<form id="upload" action="commitimageupload.php" method="POST" enctype="multipart/form-data">
<fieldset>
<legend>HTML File Upload</legend>
<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="1000000000" />
<div>
	<label for="fileselect">New Folder to upload files to:</label>
  <input type="text" value="New upload folder" name="NewUploadFolder" id="NewUploadFolder"> &nbsp Or <br>
  <select id="mySelect" name="mySelect">
  <option value="NOFILE">Select folder to upload to</option>
<?php
include "Ccrypt.php";
$dirs = array_slice(scandir('img'), 2);
foreach($dirs as $value){
  if($value !='Backgrounds'){
    echo '<option value="'.$value.'">'.decryptfilename($value).'</option>';
  }
}
echo '</select><br>';
?>
  <input type="file" id="fileselect" name="userfile[]" multiple="multiple" />
</div>

<div id="filedrag">or drop files here</div>

<div id="submitbutton">
	<button type="submit">Upload Files</button>
</div>
</fieldset>
</form>
</div>

<form action="imagenate.php" method="post" id="returnhomeform">
<input type="hidden" name="pass" value="<?php echo $_POST['pass'];?>">
</form>

<div id="wrapper">
<div id="progress"></div>
<div id="messages">
<p>Status Messages</p>
</div>
</div>

<script src="./data/filedrag.js"></script>
</body>