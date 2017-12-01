<?php
session_start();
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
        font-size: 24px;
        text-shadow: 4px 4px 4px #aaa;

      }

      #Notice{
        position:absolute; bottom:0; left:0;
 	      width:100%;
        height:12%;
        text-align:center;
        z-index:5;
        font-family: 'Gloria Hallelujah', cursive;
        color:red;
        font-size: 48px;
        text-shadow: 4px 4px 4px #aaa;
      }

      #controls{
        position:absolute; top:0; left:0;
        z-index:6;
        width:100%;
        height:15%;
        display:none;
      }

      #output{
        position:absolute; top:15%; left:0;
        z-index:6;
        width:33%;
        height:30%;
        display:none;
      }
      #outputobjects{
        position:absolute; top:100%; left:0;
        z-index:6;
        width:100%;
        height:30%;
      }
      #background{
        position:absolute;
	      background: pink no-repeat fixed center;
	       background-image: url( img/Backgrounds/OrangeBG.jpg);
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
<style>#hour{color:red}#min{color:green}#sec{color:blue}</style>

<script type="text/javascript">
var timerId
var myJSON = <?php $myJSON = trim(preg_replace('/\s+/', ' ', $myJSON)); echo '\''.$myJSON.'\''; ?>

var myObj = JSON.parse(myJSON)
function ShowControls(){
   document.getElementById("controls").style.display = "block"
}
function HideControls(){
   document.getElementById("controls").style.display = "none"
  }
function ShowHideOutput(){
  var myDisplay = document.getElementById("output").style.display
  if (myDisplay == "block"){
        document.getElementById("output").style.display = "none"
  }else{
    document.getElementById("output").style.display = "block"
  }
}
var DeviceIP =  <?php echo '\''.$_SESSION['DeviceAddress'].'\''; ?>

function S1On(){
  document.getElementById("s1").checked = true
  url = "http://" + DeviceIP + "/s1on";
  var myReturn = document.getElementById("ReturnS1");
  myReturn.data =  url

}

function S1Off(){
  document.getElementById("s1").checked = false
  url = "http://" + DeviceIP + "/s1off";
  var myReturn = document.getElementById("ReturnS1");
  myReturn.data =  url

}

function S2On(){
  document.getElementById("s2").checked = true
  url = "http://" + DeviceIP + "/s2on";
  var myReturn = document.getElementById("ReturnS2");
  myReturn.data =  url

}

function S2Off(){
  document.getElementById("s2").checked = false
  url = "http://" + DeviceIP + "/s2off";
  var myReturn = document.getElementById("ReturnS2");
  myReturn.data =  url

}

function S3On(){
  document.getElementById("s3").checked = true
  url = "http://" + DeviceIP + "/s3on";
  var myReturn = document.getElementById("ReturnS3");
  myReturn.data =  url

}

function S3Off(){
  document.getElementById("s3").checked = false
  url = "http://" + DeviceIP + "/s3off";
  var myReturn = document.getElementById("ReturnS3");
  myReturn.data =  url

}

function S4On(){
  document.getElementById("s4").checked = true
  url = "http://" + DeviceIP + "/s4on";
  var myReturn = document.getElementById("ReturnS4");
  myReturn.data =  url

}

function S4Off(){
  document.getElementById("s4").checked = false
  url = "http://" + DeviceIP + "/s4off";
  var myReturn = document.getElementById("ReturnS4");
  myReturn.data =  url

}

function Mod(val){
  document.getElementById("mod").value = val
}

function Freq(val){
  document.getElementById("freq").value = val
}

function Pulse(val){
  document.getElementById("pulse").value = val
}

function TensOn(){
  document.getElementById("tens").checked = true
  url = "http://" + DeviceIP + "/tenson?m=" + document.getElementById("mod").value + "&f=" + document.getElementById("freq").value + "&p=" + document.getElementById("pulse").value;
  var myReturn = document.getElementById("ReturnTens");
  myReturn.data = url
}
function TensOff(){
  document.getElementById("tens").checked = false
  url = "http://" + DeviceIP + "/tensoff";
  var myReturn = document.getElementById("ReturnTens");
  myReturn.data =  url

}

function PumpOn(Limit){
  if (Limit){
      url = "http://" + DeviceIP + "/pumpon?value=" + Limit ;
  } else {
     url = "http://" + DeviceIP + "/pumpon";
  }
  var myReturn = document.getElementById("ReturnPump");
  myReturn.data =  url
  document.getElementById("pump").checked = true
}

function PumpOff(){
  url = "http://" + DeviceIP + "/pumpoff";
  var myReturn = document.getElementById("ReturnPump");
  myReturn.data =  url
  document.getElementById("pump").checked = false
}

function VacOn(Limit){
  if (Limit){
      url = "http://" + DeviceIP + "/vacon?value=" + Limit ;
  } else {
     url = "http://" + DeviceIP + "/vacon";
  }
  var myReturn = document.getElementById("ReturnVac");
  myReturn.data =  url
  document.getElementById("vac").checked = true
}

function VacOff(){
  url = "http://" + DeviceIP + "/vacoff";
  var myReturn = document.getElementById("ReturnVac");
  myReturn.data =  url
  document.getElementById("vac").checked = false
}
function Servo1(value){
  url = "http://" + DeviceIP + "/servo1?pos=" + value;
  var myReturn = document.getElementById("ReturnSv1");
  myReturn.data =  url
  document.getElementById("sv1").value = value
}

function Servo2(value){
  url = "http://" + DeviceIP + "/servo2?pos=" + value;
  var myReturn = document.getElementById("ReturnSv2");
  myReturn.data =  url
  document.getElementById("sv2").value = value
}

function Loopinit(value){
  url = "http://"+ DeviceIP + "/loop?" + value;
  var myReturn = document.getElementById("ReturnSv2");
  myReturn.data = url;
  document.getElementById("looptxt").value = value
}


var LevelCount = 0
var StepCount = 0
var RepeatCount = 0
var date = new Date()
var PreviousTime = date.getTime()
var nextImage = new Image()
nextImage.src = myObj.LEVELS[0].STEPS[0].SRC
function update() {
  var date = new Date()

  var hours = date.getHours()
  if (hours < 10) hours = "0"+hours
  document.getElementById("hour").innerHTML = hours

  var minutes = date.getMinutes()
  if (minutes < 10) minutes = "0"+minutes
  document.getElementById("min").innerHTML = minutes

  var seconds = date.getSeconds()
  if (seconds < 10) seconds = "0"+seconds
  document.getElementById("sec").innerHTML = seconds
  if (StepCount < myObj.LEVELS[LevelCount].STEPS.length){
     var NewTime = date.getTime() - Number(myObj.LEVELS[LevelCount].STEPS[StepCount].DELAY)*1000
     if ( NewTime > PreviousTime){
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].S1){
           if (myObj.LEVELS[LevelCount].STEPS[StepCount].S1 == "ON"){
              S1On()
           }else {
                 S1Off()
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].S2){
           if (myObj.LEVELS[LevelCount].STEPS[StepCount].S2 == "ON"){
              S2On()
           }else {
                 S2Off()
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].S3){
           if (myObj.LEVELS[LevelCount].STEPS[StepCount].S3 == "ON"){
              S3On()
           }else {
                 S3Off()
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].S4){
           if (myObj.LEVELS[LevelCount].STEPS[StepCount].S4 == "ON"){
              S4On()
           }else {
                 S4Off()
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].MOD){
           Mod(myObj.LEVELS[LevelCount].STEPS[StepCount].MOD)
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].FREQ){
           Freq(myObj.LEVELS[LevelCount].STEPS[StepCount].FREQ)
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].PULSE){
           Pulse(myObj.LEVELS[LevelCount].STEPS[StepCount].PULSE)
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].TENS){
           if (myObj.LEVELS[LevelCount].STEPS[StepCount].TENS == "ON"){
              TensOn()
           }else {
                 TensOff()
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].PUMP){
           if (myObj.LEVELS[LevelCount].STEPS[StepCount].PUMP == "ON"){
              PumpOn()
           }else if(myObj.LEVELS[LevelCount].STEPS[StepCount].PUMP == "OFF"){
                 PumpOff()
           }else{
                 PumpOn(myObj.LEVELS[LevelCount].STEPS[StepCount].PUMP)
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].VAC){
           if (myObj.LEVELS[LevelCount].STEPS[StepCount].VAC == "ON"){
              VacOn()
           }else if(myObj.LEVELS[LevelCount].STEPS[StepCount].VAC == "OFF"){
                 VacOff()
           }else{
                 VacOn(myObj.LEVELS[LevelCount].STEPS[StepCount].VAC)
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].SV1){
           Servo1(myObj.LEVELS[LevelCount].STEPS[StepCount].SV1)
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].SV2){
           Servo2(myObj.LEVELS[LevelCount].STEPS[StepCount].SV2)
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].LOOP){
           Loopinit(myObj.LEVELS[LevelCount].STEPS[StepCount].LOOP)
        }

        if (myObj.LEVELS[LevelCount].STEPS[StepCount].SRC){
           document.getElementById("background").style.backgroundImage = "url( "+nextImage.src+")"
           if ((StepCount+1) < myObj.LEVELS[LevelCount].STEPS.length){
             nextImage.src = myObj.LEVELS[LevelCount].STEPS[StepCount+1].SRC
            }else{
              if ((LevelCount+1) < myObj.LEVELS.length){
                nextImage.src = myObj.LEVELS[LevelCount+1].STEPS[0].SRC
              }else{
                nextImage.src = myObj.LEVELS[0].STEPS[0].SRC
              }
            }
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].TXT){
           document.getElementById("Notice").innerHTML = myObj.LEVELS[LevelCount].STEPS[StepCount].TXT
        }
        StepCount++
        PreviousTime = date.getTime()
        }
  }else {
        if (myObj.LEVELS[LevelCount].REPEAT || document.getElementById("RepeatForever").checked){
           StepCount = 0
           if (!document.getElementById("RepeatForever").checked){
             RepeatCount++
           }
           if (RepeatCount >  myObj.LEVELS[LevelCount].REPEAT){
              LevelCount++
              RepeatCount = 0
           }
        }else {
              LevelCount++
              RepeatCount = 0
        }
        if (LevelCount >= myObj.LEVELS.length){
          LevelCount = 0
          RepeatCount = 0
          StepCount = 0
          clockStop()
          document.getElementById("LevelSelect" ).selectedIndex = LevelCount
          return
        }
        document.getElementById("LevelSelect" ).selectedIndex = LevelCount
  }



  timerId = setTimeout(update, 1000)
}

function clockStart() {
  if (timerId) return
  update()
}

function clockStop() {
  clearTimeout(timerId)
  timerId = null
}

function ChangeLevel(){
        LevelCount = document.getElementById("LevelSelect" ).selectedIndex
        StepCount = 0
        RepeatCount = 0
}


</script>

</head>
<body>

<div id="Title" onmouseenter="ShowControls()" >
</div>
<div id="controls" onmouseout="HideControls()">

<input type="button" onclick="clockStart()" value="Start">
<input type="button" onclick="clockStop()" value="Stop">

Level: <select id="LevelSelect" onchange="ChangeLevel()">
</select>
Repeat Forever: <input type="checkbox" id="RepeatForever" onchange="AlwaysRepeat()">
<input type="button" onclick="ShowHideOutput()" value="Show/Hide Output">
<a href="imagenate.php">Home</a>


</div>
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


</div>
<div id="outputobjects">
<p id="rxHTML">
<object id="ReturnS1" type="text/html" ></object>
<object id="ReturnS2" type="text/html" ></object>
<object id="ReturnS3" type="text/html" ></object>
<object id="ReturnPump" type="text/html" ></object>
<object id="ReturnVac" type="text/html" ></object>
<object id="ReturnS4" type="text/html" ></object>
<object id="ReturnSv1" type="text/html" ></object>
<object id="ReturnSv2" type="text/html" ></object>
<object id="ReturnTens" type="text/html" ></object>
</p>
</div>
<div id="Notice"></div>
<div id="background"></div>

<script type="text/javascript">


document.getElementById("Title").innerHTML =  document.getElementById("Title").innerHTML +  myObj.NAME
document.getElementById("Notice").innerHTML = myObj.LEVELS[0].STEPS[0].TXT
document.getElementById("background").style.backgroundImage = "url( "+myObj.LEVELS[0].STEPS[0].SRC+")"
for (i=0; i < myObj.LEVELS.length; i++){
var x = document.getElementById("LevelSelect")
var option = document.createElement("option")
option.text = myObj.LEVELS[i].TYPE
x.add(option)
}

</script>

</body>
</html>

