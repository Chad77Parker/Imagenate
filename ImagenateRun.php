<?php
include "Access.php";


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

<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
<link href="data/Imagenate.css "rel="stylesheet" type="text/css">
<script src="https://code.responsivevoice.org/responsivevoice.js?key=EbDooWoy"></script>
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
<input id="Pause" type="button" onclick="clockToggle()" value="Start">
Level: <select id="LevelSelect" onchange="ChangeLevel()">
</select>
Repeat Forever:<input type="checkbox" id="RepeatForever">
Audio:<input type="checkbox" id="AudioOn" onclick="ToggleAudio(this)">
<select id="ChooseVoice"> </select>
<input type="button" onclick="ShowHideOutput()" value="Show/Hide Output">
No Hardware:<input type="checkbox" id="NoHardware">
Max volts:<input type="range" id="MaxVolts" onchange="setMaxVolts(this)" min="0" max="255" value="60">
<input type="button" value="Return Home" onclick="document.forms[0].submit();">
</div>

<form action="imagenate.php" method="post" id="returnhomeform">
<input type="hidden" name="pass" value="<?php echo $pass;?>">
</form>

<div id="output">
<span id="hour">00</span>:<span id="min">00</span>:<span id="sec">00</span><br>
<span id="debug"></span><br>
T0<input type="radio" id="s1" >
T1<input type="radio" id="s2" >
T2<input type="radio" id="s3" >
SQZ<input type="radio" id="s4" >
PUMP<input type="radio" id="pump" >
VAC<input type="radio" id="vac" >
<br>
SV1<input type="range" id="sv1" value=90 max=180> <br>
TENS<input type="radio" id="tens" >
MOD<input type="textbox" id="mod" >
FREQ<input type="textbox" id="freq" >
PULSE<input type="textbox" id="pulse" >
VOLT<input type="textbox" id="volt"><br>
LOOP ARGS<input type="textbox" id="looptxt">
  <div id="myProgress">
  <div id="myBar"> 0%</div>
  </div>
< previous level, > next level<br>
h hold level,     c finish level<br>
d toggle device,  r toggle repeat<br>
v toggle voice,   o toggle output<br>


</div>

<div id="outputobjects">
<p id="rxHTML">
<object id="ReturnHTML" type="text/html" onload="SuccessLoad()" onerror="FailedLoad()" data=""></object>
</p>
</div>

<div id="Notice"></div>
<img id="background">

<div id="vid">
<video autoplay muted loop controls id="myVideo" src="">
</video>
<iframe src="data/silence.mp3" allow="autoplay" id="audio" style="display:none"></iframe>
<audio autoplay  id="myAudio" src="" type="audio/mpeg" style="display:none"></audio>
</div>
<div id="RunningIndicator"></div>
</body>
</html>

