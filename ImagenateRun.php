<?php
session_start();
include "Access.php";
if(isset($_POST['pass'])){
  $pass = $_POST['pass'];
}
if(isset($_SESSION['pass'])){
  $pass = $_SESSION['pass'];
}
if(isset($pass)){
  if(!accessgrant($pass)){
  die("no grant access");
}
}else{die("no pass access");}

//Load file
$filepath = $_SESSION['uploadfile'];
if (file_exists($filepath)) {
    		$myJSON = file_get_contents($filepath);
//debug print_r($xml);
	} else {
    		exit('Failed to open file.Name '.$filepath );
}

?>
<html>
<head>
<script src="http://code.responsivevoice.org/responsivevoice.js"></script>
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
<link href="data/Imagenate.css "rel="stylesheet" type="text/css">

<script type="text/javascript">
var myJSON = <?php $myJSON = trim(preg_replace('/\s+/', ' ', $myJSON)); echo '\''.$myJSON.'\''; ?> ;
var DeviceIP =  <?php echo '\''.$_SESSION['DeviceAddress'].'\''; ?>;
</script>
<script src="data/ImagenateRun.js"></script>
</head>
<body onload='initialise()'>

<div id="Title" onmouseenter="ShowControls()" >
</div>

<div id="controls" onmouseout="HideControls()">
<input type="button" onclick="clockStart()" value="Start">
<input type="button" onclick="clockStop()" value="Stop">
Level: <select id="LevelSelect" onchange="ChangeLevel()">
</select>
Repeat Forever:<input type="checkbox" id="RepeatForever">
Audio On:<input type="checkbox" id="AudioOn" onclick="ToggleAudio(this)">
<select id="ChooseVoice"> </select>
<input type="button" onclick="ShowHideOutput()" value="Show/Hide Output">
No Hardware<input type="checkbox" id="NoHardware">
<input type="button" value="Return Home" onclick="document.forms[0].submit();">
</div>

<form action="imagenate.php" method="post" id="returnhomeform">
<input type="hidden" name="pass" value="<?php echo $pass;?>">
</form>

<div id="output">
<span id="hour">00</span>:<span id="min">00</span>:<span id="sec">00</span><br>
<span id="debug"></span><br>
S1<input type="radio" id="s1" >
S2<input type="radio" id="s2" >
S3<input type="radio" id="s3" >
S4<input type="radio" id="s4" >
PUMP<input type="radio" id="pump" >
VAC<input type="radio" id="vac" >
<br>
SV1<input type="range" id="sv1" value=90 max=180> <br>
SV2<input type="range" id="sv2" value=90 max=180> <br>
TENS<input type="radio" id="tens" >
MOD<input type="textbox" id="mod" >
FREQ<input type="textbox" id="freq" >
PULSE<input type="textbox" id="pulse" > <br>
LOOP ARGS<input type="textbox" id="looptxt">
  <div id="myProgress">
  <div id="myBar"></div>
  </div>
</div>

<div id="outputobjects">
<p id="rxHTML">
<object id="ReturnHTML" type="text/html" onload="RequestHTML()" data=""></object>
</p>
</div>

<div id="Notice"></div>
<div id="background"></div>

<div id="vid">
<video autoplay muted loop controls id="myVideo" src="">
</video>
<iframe src="data/silence.mp3" allow="autoplay" id="audio" style="display:none"></iframe>
<audio autoplay  id="myAudio" src="" type="audio/mpeg" style="display:none"></audio>
</div>

</body>
</html>

