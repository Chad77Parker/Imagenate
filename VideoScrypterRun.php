<?php
include "Access.php";

?>

<html>

<head>
      <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
      <link href="data/VideoScrypterRun.css "rel="stylesheet" type="text/css">
      <script src="data/VideoScrypterRun.js"></script>
</head>

<body onload='initialise()'>

<div id="Title" onmouseenter="ShowControls()" ></div>

<div id="controls" onmouseout="HideControls()">
     <input id="Pause" type="button" onclick="Pause()" value="Start">
     File: <select id="FileSelect" onchange="ChangeFile(this)" onclick="FileSelectClicked()">
           <option value="NOFILE">Select existing file</option>
           <?php
                $files = array_slice(scandir('uploads/Scrypts'), 2);
                foreach($files as $value){
                               if($value!="Scrypts"){echo '<option value="'.$value.'">'.$value.'</option>';}
                }
           ?>
     </select>
     Repeat:<input type="checkbox" id="RepeatForever">
     <input type="button" onclick="ShowHideOutput()" value="Show/Hide Output">
     No Hardware:<input type="checkbox" id="NoHardware">
     Max volts:<input type="range" id="MaxVolts" onchange="setMaxVolts(this)" min="0" max="255" value="60">
     Speed:<label id="SpeedDisplay">1</label>X<input type="range" id="Speed" onchange="vidRate(this)" min="0" max="100" value="80">
     <input type="button" value="Return Home" onclick="document.forms[0].submit();">
     <input id="DevIP" type="hidden" value="<?php echo $_POST['deviceaddress']; ?>">
     <form action="imagenate.php" method="post" id="returnhomeform">
           <input type="hidden" name="pass" value="<?php echo $pass;?>">
     </form>
</div>

<div id="output">
     <div class="sliderbox">
          MOD F<br><input type="range" id="MFRange" min="0" max="255" onchange="setMF(this)" class="slider"><br><input type="textbox" id="ModF" >
     </div>
     <div class="sliderbox">
          MOD D<br><input type="range" id="MDCRange" min="0" max="255" onchange="setMDC(this)" class="slider"><br><input type="textbox" id="ModDC" >
     </div>
     <div class="sliderbox">
          PLS F<br><input type="range" id="PFRange" min="0" max="255" onchange="setPF(this)" class="slider"><br><input type="textbox" id="PlsF" >
     </div>
     <div class="sliderbox">
          PLS W<br><input type="range" id="PWRange" min="0" max="255" onchange="setPW(this)" class="slider"><br><input type="textbox" id="PlsW" >
     </div>
     <div class="sliderbox">
          VOLT<br><input type="range" id="VRange" min="0" max="255" onchange="setV(this)" class="slider"><br><input type="textbox" id="Volt"><br>
     </div>
     <div id="debugSpan">
          <p id="clock"></p>
          <p id="func"></p>
          <p id="debugP"></p>
     </div>
</div>

<div id="Notice"></div>
<div id="background"></div>

<div id="vid">
     <video onended=EndVid(this) ontimeupdate=UpdateTime() id="myVideo" src=""></video>
     <iframe src="data/silence.mp3" allow="autoplay" id="audio" style="display:none"></iframe>
</div>

</body>
</html>

