<html>
<head>
<title>JSON Constructor</title>
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
      #output{
        position:absolute; top:15%; left:0;
        z-index:6;
        width:50%;
        height:75%;
        overflow:auto
      }
      #imageselect{
        position:absolute; top:15%; left:50%;
        z-index:6;
        width:50%;
        height:75%;
        overflow:auto
      }
      #background{
        position:absolute;
	      background: pink no-repeat fixed center;
	       background-image: url( img/Backgrounds/BlueBG.jpg);
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
      input.numfield{
        width:5%;
      }
    </style>
<head>
<body>
<div id="Title">
Please Enter in your Program
</div>
<div id="output">

<form action="CommitUpload.php" method="post" id="MainForm">
FileName:<input type="textbox" id="filename" name="FileName">
Program:<input type="textbox" id="Program" name="Program">
Device IP: <input type="textbox" id="DeviceIP" name="deviceaddress">
Running Time: <input type="textbox" id="RunTime" name="RunTime">
<br><div id="Record_0" style="border-style:solid;border-width:5px;border-color:pink" onclick=UpdateRecords(0)>
Level:<input type="textbox" id="Level_0" name="Level[0]" class="numfield">Repeat:<input type="textbox" name="Repeat[0]" id="Repeat_0" class="numfield">Delay:<input type="textbox" id="Delay_0" name="Delay[0]" class="numfield">Notice:<input type="textbox" id="Notice_0" name="Notice[0]" value="">
S1<input type="checkbox" id="S1_0" name="S1[0]" value="true" >S2<input type="checkbox" id="S2_0" name="S2[0]" value="true" >S3<input type="checkbox" id="S3_0" name="S3[0]" value="true">S4<input type="checkbox" id="S4_0" name="S4[0]" value="true">Vac<input type="checkbox" id="Vac_0" name="Vac[0]" value="true">Pump<input type="checkbox" id="Pump_0" name="Pump[0]" value="true">
SV1<input type="range" id="Sv1_0" name="Sv1[0]" value="90" max="180">SV2<input type="range" id="Sv2_0" name="Sv2[0]" value="90" max="180" >Tens<input type="checkbox" id="Tens_0" name="Tens[0]" value="true">Modulation<input type="textbox" id="Mod_0" name="Mod[0]" class="numfield">Frequency<input type="textbox" id="Freq_0" name="Freq[0]" class="numfield">PulseWidth<input type="textbox" id="Pulse_0" name="Pulse[0]" class="numfield">LoopArgs<input type="textbox" id ="Loop_0" name="Loop[0]" value="s1onm=0&s1offm=0&s2onm=0&s2offm=0&s3onm=0&s3offm=0&s4onm=0&s4offm=0&vaconm=0&vacoffm=0&pumponm=0&pumpoffm=0&sv1onm=0&sv1onp=0&sv1offm=0&sv1offp=0&sv2onm=0&sv2onp=0&sv2offm=0&sv2offp=0&loopt=0">Image:<input type="textbox" id="Image_0" name="Image[0]" class="numfield"><input type="button" onclick="AddRecord()" value="New Step"><img id="pic_0" style="height:10%;width:10%">
</div>
</form>

<br>
</div>
<div id="imageselect">
<select id="folderselect" onchange="UpdateImages()">


<?php
$dirs = array_slice(scandir('img'), 2);
$f = 0;
foreach($dirs as $value){
  if($value !='Backgrounds'){
    $imagefiles = array_slice(scandir('img/'.$value), 2);
    $i = 1;
    $images[$f][0]=$value;
    foreach($imagefiles as $imagevalue){
      $images[$f][$i]=$imagevalue;
      $i++;
    }
    $f++;
    echo '<option value="'.$value.'">'.$value.'</option>';
  }
}
echo '</select><br>';
$f = 0;
while(count($images)>$f){
 echo '<div id="dir_'.$images[$f][0].'" class="dirofimgs" style="display:none">';
 $i=1;
 while(count($images[$f]) > $i){
   if($images[$f][$i]!="thumb"){
    $image_path = 'img/'.$images[$f][0];
    $image_name = $images[$f][$i];
    $style = "thumb";
    $image_thumb = $image_path.'/'.$style.'/'.$image_name;
if(!file_exists($image_thumb))
        $image_thumb = "image.php?image_name=$image_name&style=$style&image_path=$image_path";
     // only if file doesn't exist call the on-the-fly creating file

    echo '<img src="'.$image_thumb;
    echo '" onclick=UpdateText('.$f.','.$i.',"'.$image_path.'/'.$image_name.'","'.$image_path.'/'.$style.'/'.$image_name.'") id="image'.$f.$i.'" style="width:20%;height:20%;display:inline;border-style:hidden;border-width:5px;border-color:transparent">';
    }
    $i++;
 }
 echo '</div>';
 $f++;
}

?>

</div>

<div id="Notice"> <input type="submit" onclick="document.forms[0].submit();" />  </div>
<div id="background"></div>
<script >
var CurrentRecord = 0
var CurrentImg = ""
var StepCount = 0
function AddRecord(){
var NewRecord
var NewElement
var OldElement
var myForm = document.getElementById("MainForm")
StepCount ++
NewElement = document.createElement("div")
NewElement.id = "Record_"+StepCount
NewElement.style.border = "5px solid pink"
NewElement.setAttribute("onclick","UpdateRecords("+StepCount+")")
myForm.appendChild(NewElement)
myForm = NewElement
NewElement = document.createTextNode("Level:")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "textbox"
NewElement.className = "numfield"
NewElement.name = "Level[" + StepCount + "]"
OldElement = document.getElementById("Level_" + (StepCount - 1))
NewElement.value = OldElement.value
NewElement.id = "Level_" + StepCount
myForm.appendChild(NewElement)

NewElement = document.createTextNode("Repeat:")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "textbox"
NewElement.className = "numfield"
OldElement = document.getElementById("Repeat_" + (StepCount - 1))
NewElement.value = OldElement.value
NewElement.id = "Repeat_" + StepCount
NewElement.name = "Repeat[" + StepCount + "]"
myForm.appendChild(NewElement)

NewElement = document.createTextNode("Delay:")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "textbox"
NewElement.className = "numfield"
OldElement = document.getElementById("Delay_" + (StepCount - 1))
NewElement.value = OldElement.value
NewElement.id = "Delay_" + StepCount
NewElement.name = "Delay[" + StepCount + "]"
myForm.appendChild(NewElement)

NewElement = document.createTextNode("Notice:")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "textbox"
OldElement = document.getElementById("Notice_" + (StepCount - 1))
NewElement.value = OldElement.value
NewElement.id = "Notice_" + StepCount
NewElement.name = "Notice[" + StepCount + "]"
NewElement.value=""
myForm.appendChild(NewElement)

NewElement = document.createTextNode("S1")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "checkbox"
NewElement.id = "S1_" + StepCount
NewElement.name = "S1[" + StepCount + "]"
NewElement.value = "true"
OldElement = document.getElementById("S1_" + (StepCount - 1))
NewElement.checked = OldElement.checked
myForm.appendChild(NewElement)

NewElement = document.createTextNode("S2")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "checkbox"
NewElement.id = "S2_" + StepCount
NewElement.name = "S2[" + StepCount + "]"
NewElement.value = "true"
OldElement = document.getElementById("S2_" + (StepCount - 1))
NewElement.checked = OldElement.checked
myForm.appendChild(NewElement)

NewElement = document.createTextNode("S3")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "checkbox"
NewElement.id = "S3_" + StepCount
NewElement.name = "S3[" + StepCount + "]"
NewElement.value = "true"
OldElement = document.getElementById("S3_" + (StepCount - 1))
NewElement.checked = OldElement.checked
myForm.appendChild(NewElement)

NewElement = document.createTextNode("S4")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "checkbox"
NewElement.id = "S4_" + StepCount
NewElement.name = "S4[" + StepCount + "]"
NewElement.value = "true"
OldElement = document.getElementById("S4_" + (StepCount - 1))
NewElement.checked = OldElement.checked
myForm.appendChild(NewElement)

NewElement = document.createTextNode("Vac")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "checkbox"
NewElement.id = "Vac_" + StepCount
NewElement.name = "Vac[" + StepCount + "]"
NewElement.value = "true"
OldElement = document.getElementById("Vac_" + (StepCount - 1))
NewElement.checked = OldElement.checked

myForm.appendChild(NewElement)
NewElement = document.createTextNode("Pump")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "checkbox"
NewElement.id = "Pump_" + StepCount
NewElement.name = "Pump[" + StepCount + "]"
NewElement.value = "true"

OldElement = document.getElementById("Pump_" + (StepCount - 1))
NewElement.checked = OldElement.checked

myForm.appendChild(NewElement)

NewElement = document.createTextNode("SV1")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "range"
NewElement.max = "180"
NewElement.id = "Sv1_"+ StepCount
NewElement.name = "Sv1[" + StepCount + "]"
OldElement = document.getElementById("Sv1_" + (StepCount - 1))
NewElement.value = OldElement.value
myForm.appendChild(NewElement)

NewElement = document.createTextNode("SV2")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "range"
NewElement.max = "180"
NewElement.id = "Sv2_"+ StepCount
NewElement.name = "Sv2[" + StepCount + "]"
OldElement = document.getElementById("Sv2_" + (StepCount - 1))
NewElement.value = OldElement.value
myForm.appendChild(NewElement)

NewElement = document.createTextNode("Tens")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "checkbox"
NewElement.id = "Tens_" + StepCount
NewElement.name = "Tens[" + StepCount + "]"
NewElement.value = "true"
OldElement = document.getElementById("Tens_" + (StepCount - 1))
NewElement.checked = OldElement.checked
myForm.appendChild(NewElement)

NewElement = document.createTextNode("Modulation")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "textbox"
NewElement.className = "numfield"
OldElement = document.getElementById("Mod_" + (StepCount - 1))
NewElement.value = OldElement.value
NewElement.id = "Mod_" + StepCount
NewElement.name = "Mod[" + StepCount + "]"
myForm.appendChild(NewElement)

NewElement = document.createTextNode("Frequency")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "textbox"
NewElement.className = "numfield"
OldElement = document.getElementById("Freq_" + (StepCount - 1))
NewElement.value = OldElement.value
NewElement.id = "Freq_" + StepCount
NewElement.name = "Freq[" + StepCount + "]"
myForm.appendChild(NewElement)

NewElement = document.createTextNode("Pulse Width")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "textbox"
NewElement.className = "numfield"
OldElement = document.getElementById("Pulse_" + (StepCount - 1))
NewElement.value = OldElement.value
NewElement.id = "Pulse_" + StepCount
NewElement.name = "Pulse[" + StepCount + "]"
myForm.appendChild(NewElement)

NewElement = document.createTextNode("Loop Args")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "textbox"
OldElement = document.getElementById("Loop_" + (StepCount - 1))
NewElement.value = OldElement.value
NewElement.id = "Loop_" + StepCount
NewElement.name = "Loop[" + StepCount + "]"
myForm.appendChild(NewElement)

NewElement = document.createTextNode("Image:")
myForm.appendChild(NewElement)
NewElement = document.createElement("input")
NewElement.type = "textbox"
NewElement.className = "numfield"
OldElement = document.getElementById("Image_" + (StepCount - 1))
NewElement.value = OldElement.value
NewElement.id = "Image_" + StepCount
NewElement.name = "Image[" + StepCount + "]"
myForm.appendChild(NewElement)

NewElement = document.createElement("input")
NewElement.type = "button"
NewElement.id = "NextStep_" + StepCount
NewElement.value = "Next Step"
NewElement.onclick = AddRecord
myForm.appendChild(NewElement)

NewElement = document.createElement("img")
NewElement.id = "pic_"+StepCount
NewElement.style.width = "10%"
NewElement.style.height = "10%"
myForm.appendChild(NewElement)

}

function UpdateImages(){

<?php
$f = 0;
while(count($images)>$f){
   echo 'document.getElementById("dir_'.$images[$f][0].'").style.display = "none"
   ';
   $f++;
}
?>

var myselect = document.getElementById("folderselect")
var selection = myselect.options[myselect.selectedIndex].value
var mydiv = document.getElementById("dir_"+selection)
mydiv.style.display = "inline"
}

function UpdateText(f,i,p,t){
NewImg =  "image"+f+i
if(CurrentImg!=""){
  var myimg = document.getElementById(CurrentImg)
  myimg.style.border = "5px solid transparent"
}
var myimg = document.getElementById(NewImg)
myimg.style.border = "5px solid blue"
CurrentImg = NewImg
document.getElementById("Image_"+CurrentRecord).value = p
document.getElementById("pic_"+CurrentRecord).src = t
}

function UpdateRecords(rec){
var myRec = document.getElementById("Record_"+CurrentRecord)
myRec.style.border = "5px solid transparent"
CurrentRecord = rec
myRec = document.getElementById("Record_"+CurrentRecord)
myRec.style.border = "5px solid blue"
i = 0
s = 0
while(i < StepCount){
  s += +document.getElementById("Delay_"+i).value
  i++
}
var hours   = Math.floor(s / 3600);
  var minutes = Math.floor((s - (hours * 3600)) / 60);
  var seconds = s - (hours * 3600) - (minutes * 60);

  // round seconds
  seconds = Math.round(seconds * 100) / 100

  var result = (hours < 10 ? "0" + hours : hours);
      result += ":" + (minutes < 10 ? "0" + minutes : minutes);
      result += ":" + (seconds  < 10 ? "0" + seconds : seconds);

document.getElementById("RunTime").value = result
}
</script></body>
</html>