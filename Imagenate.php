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
  }else if(obj.value == "Video Scrypter"){
   document.getElementById('frm').action = 'videoscrypter.php'
  }else if(obj.value == "Video Scrypter Run"){
   document.getElementById('frm').action = 'videoscrypterrun.php'
  }else{
   document.getElementById('frm').action = 'CommitUpload.php'
  }
 document.getElementById('frm').submit();
}

function VerifyPass(){
  pass = document.getElementById('pass');
  test=document.getElementById("n").value;
  for(i=0;i<=pass.value.length;i++){
    subject=String(CryptoJS.SHA256(pass.value.substr(0,i)))
    x=subject.search(test)
     if(String(CryptoJS.SHA256(pass.value.substr(0,i))).search(test)>-1){
       document.getElementById("hidedisplay").style.display="block";
       return
     }else{
       document.getElementById("hidedisplay").style.display="none";
     }
  }

}

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9/core.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9/sha256.js"></script>


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
    <input type="password" id="pass" value="<?php session_start(); if(isset($_SESSION['pass'])){echo $_SESSION['pass'];} ?>" name="pass" oninput="VerifyPass()" autofocus /><br>
    <div id="hidedisplay">
    <input type="text" value="<?php if(isset($_SESSION['DeviceAddress'])){echo $_SESSION['DeviceAddress'];}else{echo "mistress";} ?>" name="deviceaddress" /><br>
    <select id="mySelect" name="mySelect">
    <option value="NOFILE">Select existing file</option>
<?php
$files = array_slice(scandir('uploads'), 2);
foreach($files as $value){
if($value!="Scrypts"){echo '<option value="'.$value.'">'.$value.'</option>';}
}    

?>

    </select><br>
    
    <input type="hidden" value="<?php echo hash("sha256","destiny".date("Y",time())); ?>" id="n">
    
    <input type="submit" value="Send File and Device IP" /> <br>
    
    <input type="button" value="Create New File" onClick="submitMe(this)"><br>
    
    <input type="button" value="Modify File" onClick="submitMe(this)"><br>

    <input type="button" value="Upload images" onClick="submitMe(this)"><br>
    
    <input type="button" value="Update Slideshow" onClick="submitMe(this)"><br>

    <input type="button" value="Control Test Page" onClick="submitMe(this)"><br>
    
    <input type="button" value="Video Scrypter" onClick="submitMe(this)"><br>

    <input type="button" value="Video Scrypter Run" onClick="submitMe(this)"><br>

</div>
</form>
</div>
</body>