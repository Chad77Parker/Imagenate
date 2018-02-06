<?php
include "Access.php";
if(!accessgrant($_POST['pass'])){
  die("no access");
}
?>
<html>
<head>
<title>Imagenate</title>
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="styles.css" />
<link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Tangerine">
    <style>
      #Title{
        position:absolute; top:0; left:0;
 	      width:100%;
        height:8%;
        text-align:center;
        z-index:5;
        font-family: 'Gloria Hallelujah', cursive;
        color:red;
        font-size: 48px;
        text-shadow: 4px 4px 4px #aaa;
      }
      #Notice{
        position:absolute; bottom:0; left:0;
 	      width:100%;
        height:8%;
        text-align:center;
        z-index:5;
        font-family: 'Gloria Hallelujah', cursive;
        color:red;
        font-size: 48px;
        text-shadow: 4px 4px 4px #aaa;
      }

      #controls{
        position:absolute; top:10%; left:20%;
        z-index:6;
        width:80%;
        height:15%;
        text-align:left;
        color:red;
        font-size: 24px;
        text-shadow: 4px 4px 4px #aaa;
      }
      #output{
        position:absolute; top:15%; left:0;
        z-index:6;
        width:33%;
        height:30%
      }
      #background{
        position:absolute;
	      background: pink no-repeat fixed center;
	       background-image: url( img/Backgrounds/WhiteBG.jpg);
         background-repeat: no-repeat;
         background-attachment: fixed;
         background-size: contain;
         background-position: 50% 0%;
        z-index:1;
	      width:100%;
	      height:100%;
	      top:0;
	      left:0;
	      text-align:center;
      }

    </style>
</head>
<body>
<div id="Title">
Image Upload
</div>
<div id="background"></div>
<div id="controls">
<!-- The data encoding type, enctype, MUST be specified as below -->
<form id="upload" action="commitimageupload.php" method="POST" enctype="multipart/form-data">

<fieldset>
<legend>HTML File Upload</legend>

<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="3000000" />

<div>
	<label for="fileselect">Files to upload:</label>
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

<div id="progress"></div>

<div id="messages">
<p>Status Messages</p>
</div>

</div>
<script src="filedrag.js"></script>
</body>