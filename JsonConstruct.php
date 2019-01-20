<?php
include "Access.php";
if(!accessgrant($_POST['pass'])){
  die("no access");
}
?>
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
        z-index:2;
        font-family: 'Gloria Hallelujah', cursive;
        color:red;
        font-size: 2vw;
        text-shadow: 4px 4px 4px #aaa;
      }
      #FormFooter{
        position:absolute; bottom:8%; left:0;
 	      width:100%;
        height:6%;
        text-align:center;
        z-index:2;
        font-family: 'Gloria Hallelujah', cursive;
        color:red;
        font-size: 48px;
        text-shadow: 4px 4px 4px #aaa;
      }

      #formHeader{
        position:absolute; top:4%; left:0;
        z-index:3;
        width:80%;
        height:8%;
        text-align:left;
        color:red;
        font-size: 24px;
        text-shadow: 4px 4px 4px #aaa;
      }
      #FolderSelect{
        position:absolute;
        z-index:3;
        height:8%;
        width:50%;
        top:8%;
        overflow:hidden;
      }
      #FormMain{
        position:absolute; top:16%; left:0;
        z-index:2;
        width:50%;
        height:74%;
        overflow:auto
      }
      #FormMainOverlay{
        position:absolute; top:20%; left:0;
        z-index:3;
        width:50%;
        height:66%;
        overflow:auto
      }
      #imageselect{
        position:absolute; top:16%; left:50%;
        z-index:2;
        width:50%;
        height:74%;
        overflow:auto;
      }
      #imageselectOverlay{
        position:absolute; top:20%; left:50%;
        z-index:3;
        width:50%;
        height:66%;
        overflow:hidden;
      }
      #MainOverlay{
         width:100%;
         height:100%;
         background: pink;
         object-fit: contain;
         overflow: hidden;
         border-style:solid;
         border-width:10px;
         border-color:pink;
      }
      #background{
        position:absolute;
	      background: pink no-repeat fixed center;
	       background-image: url(img/backgrounds/CyanBG.jpg );
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
      input.textfield{
        width:20%;
      }
      input.remaining{
        width:auto;
      }
      td.tdclear{

    }
    img.tableimg{
      max-height:90px;
    }
    </style>
    
<script>
var thisRec=0
var preRec=(-1)
var curRec=0
var curImg=''
function upInHTML(mychild){
  tempid = mychild.id
  if (tempid.search('Modms')>=0){
       tempid = tempid.replace('Modms', 'Mod')
       newvalue = Math.round(mychild.value*25)
       document.getElementById(tempid).setAttribute('value',newvalue)
  }
  if (tempid.search('Freqhz')>=0){
       tempid = tempid.replace('Freqhz', 'Freq')
       newvalue = Math.round(Math.log(mychild.value)/Math.log(1.034))
       document.getElementById(tempid).setAttribute('value',newvalue)
  }
  if (tempid.search('Pulsepc')>=0){
       tempid = tempid.replace('Pulsepc', 'Pulse')
       newvalue = Math.round(mychild.value*255/100)
       document.getElementById(tempid).setAttribute('value',newvalue)
  }
  mychild.setAttribute('value',mychild.value)
  
}

function AddRecord(){
try{
var myInHTML =""

var level,repeat,delay,notice,s1,s2,s3,s4,vac,pump,tens,sv1,sv2,mod,freq,pulse,largs
preRec<0?level = "":level = document.getElementById('Level_'+preRec).value
preRec<0?repeat = "0":repeat = document.getElementById('Repeat_'+preRec).value
preRec<0?delay = "5":delay = document.getElementById('Delay_'+preRec).value
preRec<0?notice = "":notice = document.getElementById('Notice_'+preRec).value
preRec<0?s1 = "false":s1 = document.getElementById('S1_'+preRec).value
preRec<0?s2 = "false":s2 = document.getElementById('S2_'+preRec).value
preRec<0?s3 = "false":s3 = document.getElementById('S3_'+preRec).value
preRec<0?s4 = "false":s4 = document.getElementById('S4_'+preRec).value
preRec<0?vac = "false":vac = document.getElementById('Vac_'+preRec).value
preRec<0?pump = "false":pump = document.getElementById('Pump_'+preRec).value
preRec<0?tens = "false":tens = document.getElementById('Tens_'+preRec).value
preRec<0?sv1 = "90":sv1 = document.getElementById('Sv1_'+preRec).value
preRec<0?sv2 = "90":sv2 = document.getElementById('Sv2_'+preRec).value
preRec<0?mod = "0":mod = document.getElementById('Mod_'+preRec).value
preRec<0?freq = "0":freq = document.getElementById('Freq_'+preRec).value
preRec<0?pulse = "0":pulse = document.getElementById('Pulse_'+preRec).value
preRec<0?largs = "s1onm=0&s1offm=0&s2onm=0&s2offm=0&s3onm=0&s3offm=0&s4onm=0&s4offm=0&vaconm=0&vacoffm=0&pumponm=0&pumpoffm=0&sv1onm=0&sv1onp=0&sv1offm=0&sv1offp=0&sv2onm=0&sv2onp=0&sv2offm=0&sv2offp=0&loopt=0":largs = document.getElementById('Loop_'+preRec).value

myInHTML=myInHTML+'<div id="Record_'+thisRec+'" style="border-style:solid;border-width:5px;border-color:blue" onclick=UpdateRecords(this) ><table class="Record">'
myInHTML=myInHTML+'<tr><td class="tdclear">'
myInHTML=myInHTML+'Level:<input type="textbox" id="Level_'+thisRec+'" name="Level['+thisRec+']" class="textfield" value="'+level+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'Repeat:<input type="textbox" name="Repeat['+thisRec+']" id="Repeat_'+thisRec+'" class="numfield" value="'+repeat+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'Delay:<input type="textbox" id="Delay_'+thisRec+'" name="Delay['+thisRec+']" class="numfield" value="'+delay+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'Notice:<input type="textbox" id="Notice_'+thisRec+'" name="Notice['+thisRec+']" value="" class="remaining" value="'+notice+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'</td>'
myInHTML=myInHTML+'<td class="tdclear" rowspan="3">'
myInHTML=myInHTML+'<img id="pic_'+thisRec+'" class="tableimg">'
myInHTML=myInHTML+'</td></tr><tr>'
myInHTML=myInHTML+'<td class="tdclear"><input type="button" value="S1" onclick=SetCol(this,"S1_'+thisRec+'") style="background-color:'+(s1=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="S1_'+thisRec+'" name="S1['+thisRec+']" value="'+s1+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input type="button" value="S2" onclick=SetCol(this,"S2_'+thisRec+'") style="background-color:'+(s2=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="S2_'+thisRec+'" name="S2['+thisRec+']" value="'+s2+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input type="button" value="S3" onclick=SetCol(this,"S3_'+thisRec+'") style="background-color:'+(s3=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="S3_'+thisRec+'" name="S3['+thisRec+']" value="'+s3+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input type="button" value="S4" onclick=SetCol(this,"S4_'+thisRec+'") style="background-color:'+(s4=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="S4_'+thisRec+'" name="S4['+thisRec+']" value="'+s4+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input type="button" value="VAC" onclick=SetCol(this,"Vac_'+thisRec+'") style="background-color:'+(vac=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="Vac_'+thisRec+'" name="Vac['+thisRec+']" value="'+vac+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input type="button" value="PUMP" onclick=SetCol(this,"Pump_'+thisRec+'") style="background-color:'+(pump=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="Pump_'+thisRec+'" name="Pump['+thisRec+']" value="'+pump+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input type="button" value="TENS" onclick=SetCol(this,"Tens_'+thisRec+'") style="background-color:'+(tens=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="Tens_'+thisRec+'" name="Tens['+thisRec+']" value="'+tens+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'SV1<input type="range" id="Sv1_'+thisRec+'" name="Sv1['+thisRec+']" value="'+sv1+'" max="180" oninput=upInHTML(this)>'
myInHTML=myInHTML+'SV2<input type="range" id="Sv2_'+thisRec+'" name="Sv2['+thisRec+']" value="'+sv2+'" min="45" max="75"  oninput=upInHTML(this)>'
myInHTML=myInHTML+'</tr><tr>'
myInHTML=myInHTML+'<td class="tdclear">'
myInHTML=myInHTML+'Modulation(s)<input type="textbox" id="Modms_'+thisRec+'" oninput=upInHTML(this) class="numfield"><input type="hidden" id="Mod_'+thisRec+'" name="Mod['+thisRec+']" class="numfield" value="'+mod+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'Frequency(Hz)<input type="textbox" id="Freqhz_'+thisRec+'" oninput=upInHTML(this) class="numfield"><input type="hidden" id="Freq_'+thisRec+'" name="Freq['+thisRec+']" class="numfield" value="'+freq+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'PulseWidth(%)<input type="textbox" id="Pulsepc_'+thisRec+'" oninput=upInHTML(this) class="numfield"><input type="hidden" id="Pulse_'+thisRec+'" name="Pulse['+thisRec+']" class="numfield" value="'+pulse+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'LoopArgs<input type="textbox" id ="Loop_'+thisRec+'" name="Loop['+thisRec+']" class="remaining" value="'+largs+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input type="hidden" id="Image_'+thisRec+'" name="Image['+thisRec+']" class="numfield" value="" oninput=upInHTML(this)>'
myInHTML=myInHTML+'</td>'
myInHTML=myInHTML+'</table>'
if(preRec<0){
  document.getElementById("FormMain").innerHTML=myInHTML
}else{
document.getElementById("FormMain").innerHTML+=myInHTML
}
if(curRec!=thisRec){document.getElementById('Record_'+curRec).style.border = "5px solid transparent"}
document.getElementById('Record_'+thisRec).scrollIntoView()
curRec = thisRec
thisRec= thisRec+1
preRec= preRec+1

}
catch(err){
document.getElementById("FormMain").innerHTML+=err.message
}
}

function SetCol(btn,Bid){
  myBtn = document.getElementById(Bid)
  if(myBtn.value == "true"){
    btn.style.backgroundColor = 'red'
    myBtn.value = "false"
  }
  else{
    btn.style.backgroundColor = 'green'
    myBtn.value = "true"
  }
}
function  myShow(myObj){
 var x = myObj.querySelectorAll("img")
 myObj.style.height="74%"
 myObj.style.width="50%"
 myObj.style.overflow="auto"
 var i=0
 while(i<x.length){
   x[i].style.display="inline"
   x[i].style.height="10%"
   x[i].style.borderColor="pink"
   i++
 }
}

function myHide(myObj){
       var x = myObj.querySelectorAll("img")
        myObj.style.height="8%"
        myObj.style.width="5%"
        myObj.style.overflow="hidden"
       var i=0
       while(i<x.length){
         if(x[i].getAttribute("data-selected")!="true"){
         x[i].style.display="none"
         }
         x[i].style.height="100%"
         x[i].style.borderColor="transparent"
         i++
       }

}

function FolderUpdate(myObj){
       var myselect = document.querySelector("img[data-selected='true']")
       myselect.setAttribute("data-selected", "false")
       myObj.setAttribute("data-selected", "true")
       UpdateImages()
}

function ImageOverlay(myObj){
  document.getElementById("imageselectOverlay").style.display="inline"
  document.getElementById("MainOverlay").src=myObj.src
  
}
function ImageOverlayHide(myObj){
  document.getElementById("imageselectOverlay").style.display="none"
}
function UpdateImages(){
//hide all images
var x = document.getElementsByClassName("dirofimgs")
i=0
console.log(x)
while(i<x.length){
  x[i].style.display = "none"
  i++
}
//show only selected images
var myselect = document.querySelector("img[data-selected='true']")

if(myselect != null){
  var selection = myselect.getAttribute("data-value")
}

var mydiv = document.getElementById("dir_"+selection)
mydiv.style.display = "inline"
n=mydiv.childElementCount+1
f=1
while(n>f){
  loadimgid="imagef"+myselect.getAttribute("data-index")+"i"+f
  loadimg=document.getElementById(loadimgid).getAttribute("data_src")
  document.getElementById("imagef"+myselect.getAttribute("data-index")+"i"+f).setAttribute("src", loadimg)
  f++
}
myHide(document.getElementById("FolderSelect"))
}

function UpdateText(f,i,p,t){
NewImg =  "imagef"+f+'i'+i
if(curImg!=""){
  var myimg = document.getElementById(curImg)
  myimg.style.border = "5px solid transparent"
}
var myimg = document.getElementById(NewImg)
myimg.style.border = "5px solid blue"
curImg = NewImg
document.getElementById("Image_"+curRec).value = p
document.getElementById("pic_"+curRec).src = "imagedecode.php?filename="+t
}

function UpdateRecords(myRec){
document.getElementById('Record_'+curRec).style.border = "5px solid transparent"
curRec = myRec.id.substr(7)
myRec.style.border = "5px solid blue"
i = 0
s = 0
while(i < thisRec){
  s += document.getElementById("Delay_"+i).value/1
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
function doc_keyUp(e) {

    // this would test for whichever key is 65 and the ctrl key at the same time
    if (e.keyCode == 192) {
        // call your function to do the thing
        AddRecord();
    }
}
// register the handler
document.addEventListener('keyup', doc_keyUp, false);
</script>
</head>
<body onload=UpdateImages()>
<div id="Title">
Please Enter in your Program
</div>
<form action="CommitUpload.php" method="post" id="MainForm">
<div id="FormHeader">
<input type="hidden" name="pass" value="<?php echo $_POST['pass']; ?>">
FileName:<input type="textbox" id="filename" name="FileName" class="textfield">
Program:<input type="textbox" id="Program" name="Program"  class="textfield">
Running Time: <input type="textbox" id="RunTime" name="RunTime" class="textfield">
</div>
<?php
include 'ccrypt.php';
$selectHTML = '<div id="FolderSelect" onmouseover=myShow(this) onmouseout=myHide(this) onclick=myShow(this)>';
$dirs = array_slice(scandir('img'), 2);
$f = 0;
foreach($dirs as $value){
  if($value !='Backgrounds'){
    $imagefiles = array_slice(scandir('img/'.$value.'/slide'), 2);
    $i = 1;
    $images[$f]=array();
    $images[$f][0]=$value;
    foreach($imagefiles as $imagevalue){
      $images[$f][$i]=$imagevalue;
      $i++;
    }
    $image_thumb='img/'.$images[$f][0].'/thumb/'.$images[$f][1];
    $src = 'imagedecode.php?filename='.$image_thumb;
if(!file_exists($image_thumb)){
        $src = 'image.php?image_name='.$images[$f][1].'&style=thumb&image_path='.$images[$f][0];
     // only if file doesn't exist call the on-the-fly creating file
    }
     if($f == 0){$fbool = 'style="display:inline;height:100%;border-style:solid;border-width:5px;border-color:transparent" data-selected="true"';}else{$fbool = 'style="display:none;height:100%;border-style:solid;border-width:5px;border-color:pink" data-selected="false"';}
     $selectHTML= $selectHTML.'<img id="Folder_'.$f.'" data-index="'.$f.'" '.$fbool.' data-value="'.$value.'" data-readvalue="'.decryptfilename($value).'" src="'.$src.'" onclick="FolderUpdate(this)" onmouseover="ImageOverlay(this)" onmouseout="ImageOverlayHide(this)">';
  $f++;
  }
}
$selectHTML = $selectHTML.'</div>';
?>
<?php
echo $selectHTML;
?>
<div id="FormMain">
</div>
<div id="imageselectOverlay" style="display:none; z-index:20"><img id="MainOverlay"></div>

</form>
</div>
<div id="imageselect">
<?php
$f = 0;
while(count($images)>$f){
 echo '<div id="dir_'.$images[$f][0].'" class="dirofimgs" style="display:none">';
 $i=1;
 while(count($images[$f]) > $i){
   if($images[$f][$i]!="thumb" && $images[$f][$i]!="slide"){
    $image_path = 'img/'.$images[$f][0];
    $image_name = $images[$f][$i];
    $style = "thumb";
    $image_thumb = $image_path.'/'.$style.'/'.$image_name;
    $src = 'imagedecode.php?filename='.$image_thumb;
if(!file_exists($image_thumb)){
        $src = "image.php?image_name=$image_name&style=$style&image_path=$image_path";
     // only if file doesn't exist call the on-the-fly creating file
    }
    echo '<img data_src="'.$src;
    echo '" onclick=UpdateText('.$f.','.$i.',"imagedecode.php?filename='.$image_path.'/slide/'.$image_name.'","';
    echo $image_path.'/'.$style.'/'.$image_name.'") id="imagef'.$f.'i'.$i.'" style="width:20%;display:inline;border-style:solid;border-width:5px;border-color:transparent">';
    }
    $i++;
 }
 echo '</div>';
 $f++;
}

?>

</div>
<form action="imagenate.php" method="post">
<input type="hidden" name="pass" value="<?php echo $_POST['pass'];?>">
</form>
<div id="FormFooter"> <input type="button" onclick="AddRecord()" value="Next Step"><input type="submit" onclick="document.forms[0].submit();" />
<input type="button" value="Return Home" onclick="document.forms[1].submit();">  </div>
<div id="background"></div>
<script >
AddRecord()
</script></body>
</html>