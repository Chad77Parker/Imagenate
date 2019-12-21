<html>
<head>
<title>Imagenate</title>
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
<link href="data/Imagenate.css" rel="stylesheet" type="text/css" >
<script>
function submitMe(obj){
  if(obj.value == "Create New File"){
   document.getElementById('frm').action = 'jsonconstruct.php'
  }else if(obj.value=="Modify File"){
   document.getElementById('frm').action = 'modifyjson.php'
  }else if(obj.value == "Upload images"){
   document.getElementById('frm').action = 'uploadimages.php'
  }else if(obj.value == "Update Slideshow"){
   document.getElementById('frm').action = 'slideshow.php'
  }else if(obj.value == "Control Test Page"){
   document.getElementById('frm').action = 'Control.html'
  }else{
   document.getElementById('frm').action = 'CommitUpload.php'
  }
 document.getElementById('frm').submit();
}

function VerifyPass(){
  pass = document.getElementById('pass');
  d = new Date();
  n = pass.value;
  s = "destiny"+d.getFullYear()
  v = n.search(s);
  if(v<0){
   document.getElementById("hidedisplay").style.display="none";
  }else{
   document.getElementById("hidedisplay").style.display="block";
  }
}

</script>
</head>
<body onload=VerifyPass()>
<div id="Title">
Welcome to Imagenate
</div>
<div id="backgroundhome"></div>
<div id="login">
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="CommitUpload.php" method="POST" id="frm">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    <!-- Name of input element determines name in $_FILES array -->
    <input type="password" id="pass" value="<?php
include "Access.php";
if(isset($_POST['pass'])){
if(accessgrant($_POST['pass'])){
  echo $_POST['pass'];
}
}
?>" name="pass" oninput="VerifyPass()" autofocus /><br>
    <div id="hidedisplay">
    <input type="text" value="Enter device ip address" name="deviceaddress" /><br>
    <select id="mySelect" name="mySelect">
    <option value="NOFILE">Select existing file</option>
<?php
$files = array_slice(scandir('uploads'), 2);
foreach($files as $value){
echo '<option value="'.$value.'">'.$value.'</option>';
}    

?>

    </select><br>
    
    <input type="submit" value="Send File and Device IP" /> <br>
    
    <input type="button" value="Create New File" onClick="submitMe(this)"><br>
    
    <input type="button" value="Modify File" onClick="submitMe(this)"><br>

    <input type="button" value="Upload images" onClick="submitMe(this)"><br>
    
    <input type="button" value="Update Slideshow" onClick="submitMe(this)"><br>

    <input type="button" value="Control Test Page" onClick="submitMe(this)">
</div>
</form>
</div>
</body>