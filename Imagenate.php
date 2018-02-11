<html>
<head>
<title>Imagenate</title>
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
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
        position:absolute; bottom:10%; left:20%;
        z-index:6;
        width:80%;
        height:15%;
        text-align:left;
        color:red;
        font-size: 24px;
        text-shadow: 4px 4px 4px #aaa;
      }
      #hidedisplay{
        display:none;
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
	       background-image: url( img/Backgrounds/scene1.jpg);
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
<script>
function submitMe(obj){
  if(obj.value == "Create New File"){
   document.getElementById('frm').action = 'jsonconstruct.php'
  }else if(obj.value == "Upload images"){
   document.getElementById('frm').action = 'uploadimages.php'
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
<body>
<div id="Title">
Welcome to Imagenate
</div>
<div id="background"></div>
<div id="controls">
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="CommitUpload.php" method="POST" id="frm">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    <!-- Name of input element determines name in $_FILES array -->
    <input type="text" value="password" id="pass" name="pass" oninput="VerifyPass()"/><br>
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
    
    <input type="button" value="Upload images" onClick="submitMe(this)"><br>

    <input type="button" value="Control Test Page" onClick="submitMe(this)">
</div>
</form>
</div>
</body>