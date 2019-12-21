var myObj = JSON.parse(myJSON)
var thisRec=0
var preRec=(-1)
var curRec=0
var curImg=''

function Initialise(){
AddRecord()
UpdateImages()
LoadJSON()
}

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
       newvalue = Math.round(mychild.value/2)
       document.getElementById(tempid).setAttribute('value',newvalue)
  }
  mychild.setAttribute('value',mychild.value)

}

function AddRecord(){
try{
var myInHTML =""

var level,repeat,delay,notice,s1,s2,s3,s4,vac,pump,tens,playonce,sv1,sv2,mod,freq,pulse,largs
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
preRec<0?playonce = "false":playonce = document.getElementById('Playonce_'+preRec).value
preRec<0?sv1 = "90":sv1 = document.getElementById('Sv1_'+preRec).value
preRec<0?sv2 = "90":sv2 = document.getElementById('Sv2_'+preRec).value
preRec<0?mod = "0":mod = document.getElementById('Mod_'+preRec).value
preRec<0?freq = "0":freq = document.getElementById('Freq_'+preRec).value
preRec<0?pulse = "0":pulse = document.getElementById('Pulse_'+preRec).value
preRec<0?largs = "s1onm=0&s1offm=0&s2onm=0&s2offm=0&s3onm=0&s3offm=0&s4onm=0&s4offm=0&vaconm=0&vacoffm=0&pumponm=0&pumpoffm=0&sv1onm=0&sv1onp=0&sv1offm=0&sv1offp=0&sv2onm=0&sv2onp=0&sv2offm=0&sv2offp=0&loopt=0":largs = document.getElementById('Loop_'+preRec).value
preRec<0?modms = "0":modms = document.getElementById('Modms_'+preRec).value
preRec<0?freqhz = "0":freqhz = document.getElementById('Freqhz_'+preRec).value
preRec<0?pulsepc = "0":pulsepc = document.getElementById('Pulsepc_'+preRec).value
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
myInHTML=myInHTML+'<td class="tdclear"><input id="ButS1_'+thisRec+'" type="button" value="S1" onclick=SetCol(this,"S1_'+thisRec+'") style="background-color:'+(s1=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="S1_'+thisRec+'" name="S1['+thisRec+']" value="'+s1+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input id="ButS2_'+thisRec+'" type="button" value="S2" onclick=SetCol(this,"S2_'+thisRec+'") style="background-color:'+(s2=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="S2_'+thisRec+'" name="S2['+thisRec+']" value="'+s2+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input id="ButS3_'+thisRec+'" type="button" value="S3" onclick=SetCol(this,"S3_'+thisRec+'") style="background-color:'+(s3=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="S3_'+thisRec+'" name="S3['+thisRec+']" value="'+s3+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input id="ButS4_'+thisRec+'" type="button" value="S4" onclick=SetCol(this,"S4_'+thisRec+'") style="background-color:'+(s4=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="S4_'+thisRec+'" name="S4['+thisRec+']" value="'+s4+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input id="ButVAC_'+thisRec+'" type="button" value="VAC" onclick=SetCol(this,"Vac_'+thisRec+'") style="background-color:'+(vac=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="Vac_'+thisRec+'" name="Vac['+thisRec+']" value="'+vac+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input id="ButPUMP_'+thisRec+'" type="button" value="PUMP" onclick=SetCol(this,"Pump_'+thisRec+'") style="background-color:'+(pump=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="Pump_'+thisRec+'" name="Pump['+thisRec+']" value="'+pump+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input id="ButTENS_'+thisRec+'" type="button" value="TENS" onclick=SetCol(this,"Tens_'+thisRec+'") style="background-color:'+(tens=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="Tens_'+thisRec+'" name="Tens['+thisRec+']" value="'+tens+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'<input id="ButPLAYONCE_'+thisRec+'" type="button" value="PLAYONCE" onclick=SetCol(this,"Playonce_'+thisRec+'") style="background-color:'+(playonce=='false'?'red':'green')+';">'
myInHTML=myInHTML+'<input type="hidden" id="Playonce_'+thisRec+'" name="Playonce['+thisRec+']" value="'+playonce+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'SV1<input type="range" id="Sv1_'+thisRec+'" name="Sv1['+thisRec+']" value="'+sv1+'" max="180" oninput=upInHTML(this)>'
myInHTML=myInHTML+'SV2<input type="range" id="Sv2_'+thisRec+'" name="Sv2['+thisRec+']" value="'+sv2+'" min="45" max="75"  oninput=upInHTML(this)>'
myInHTML=myInHTML+'</tr><tr>'
myInHTML=myInHTML+'<td class="tdclear">'
myInHTML=myInHTML+'Modulation(s)<input type="textbox" id="Modms_'+thisRec+'" value="'+modms+'" oninput=upInHTML(this) class="numfield"><input type="hidden" id="Mod_'+thisRec+'" name="Mod['+thisRec+']" class="numfield" value="'+mod+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'Frequency(Hz)<input type="textbox" id="Freqhz_'+thisRec+'" value="'+freqhz+'" oninput=upInHTML(this) class="numfield"><input type="hidden" id="Freq_'+thisRec+'" name="Freq['+thisRec+']" class="numfield" value="'+freq+'" oninput=upInHTML(this)>'
myInHTML=myInHTML+'PulseWidth(us)<input type="textbox" id="Pulsepc_'+thisRec+'" value="'+pulsepc+'" oninput=upInHTML(this) class="numfield"><input type="hidden" id="Pulse_'+thisRec+'" name="Pulse['+thisRec+']" class="numfield" value="'+pulse+'" oninput=upInHTML(this)>'
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
document.getElementById("pic_"+curRec).src = t
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

function LoadJSON() {
var Steps = 0
var LevelCount = 0
var StepCount = 0

//check for end of levels
while(LevelCount<myObj.LEVELS.length){
   document.getElementById("Program").value=myObj.NAME
    //check for end of level
  while(Steps < myObj.LEVELS[LevelCount].STEPS.length){
       mytxt=document.getElementById("Level_"+StepCount)
       mytxt.value=myObj.LEVELS[LevelCount].TYPE
       mytxt=document.getElementById("Repeat_"+StepCount).value
       mytxt.value=myObj.LEVELS[LevelCount].REPEAT
       mytxt=document.getElementById("Delay_"+StepCount).value
       mytxt.value=myObj.LEVELS[LevelCount].STEPS[Steps].DELAY

       if (myObj.LEVELS[LevelCount].STEPS[Steps].S1){
           if (myObj.LEVELS[LevelCount].STEPS[Steps].S1 == "ON"){
              document.getElementById("ButS1_"+StepCount).style.backgroundColor="green"
              document.getElementById("S1_"+StepCount).value="true"
           }else {
              document.getElementById("ButS1_"+StepCount).style.backgroundColor="red"
              document.getElementById("S1_"+StepCount).value="false"
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].S2){
           if (myObj.LEVELS[LevelCount].STEPS[Steps].S2 == "ON"){
             document.getElementById("ButS2_"+StepCount).style.backgroundColor="green"
              document.getElementById("S2_"+StepCount).value="true"
           }else {
              document.getElementById("ButS2_"+StepCount).style.backgroundColor="red"
              document.getElementById("S2_"+StepCount).value="false"
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].S3){
           if (myObj.LEVELS[LevelCount].STEPS[Steps].S3 == "ON"){
             document.getElementById("ButS3_"+StepCount).style.backgroundColor="green"
              document.getElementById("S3_"+StepCount).value="true"
           }else {
              document.getElementById("ButS3_"+StepCount).style.backgroundColor="red"
              document.getElementById("S3_"+StepCount).value="false"
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].S4){
           if (myObj.LEVELS[LevelCount].STEPS[Steps].S4 == "ON"){
              document.getElementById("ButS4_"+StepCount).style.backgroundColor="green"
              document.getElementById("S4_"+StepCount).value="true"
           }else {
              document.getElementById("ButS4_"+StepCount).style.backgroundColor="red"
              document.getElementById("S4_"+StepCount).value="false"
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].PLAYONCE){
           if (myObj.LEVELS[LevelCount].STEPS[Steps].PLAYONCE == "ON"){
              document.getElementById("ButPLAYONCE_"+StepCount).style.backgroundColor="green"
              document.getElementById("Playonce_"+StepCount).value="true"
           }else {
              document.getElementById("ButPLAYONCE_"+StepCount).style.backgroundColor="red"
              document.getElementById("Playonce_"+StepCount).value="false"
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].MOD){
              document.getElementById("Mod_"+Steps).value=myObj.LEVELS[LevelCount].STEPS[StepCount].MOD
              document.getElementById("Modms_"+StepCount).value=myObj.LEVELS[LevelCount].STEPS[StepCount].MOD/25
           }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].FREQ){
              document.getElementById("Freq_"+StepCount).value=myObj.LEVELS[LevelCount].STEPS[StepCount].FREQ
              document.getElementById("Freqhz_"+StepCount).value=Math.round(Math.log(1.034)*Math.exp(myObj.LEVELS[LevelCount].STEPS[StepCount].FREQ))
        }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].PULSE){
              document.getElementById("Pulse_"+StepCount).value=myObj.LEVELS[LevelCount].STEPS[StepCount].PULSE
              document.getElementById("Pulsepc_"+StepCount).value=myObj.LEVELS[LevelCount].STEPS[StepCount].PULSE*2
        }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].TENS){
           if (myObj.LEVELS[LevelCount].STEPS[Steps].TENS == "ON"){
              document.getElementById("ButTENS_"+StepCount).style.backgroundColor="green"
              document.getElementById("Tens_"+StepCount).value="true"
           }else {
              document.getElementById("ButTENS_"+StepCount).style.backgroundColor="red"
              document.getElementById("Tens_"+StepCount).value="false"
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].PUMP){
           if (myObj.LEVELS[LevelCount].STEPS[Steps].PUMP == "ON"){
              document.getElementById("ButPUMP_"+StepCount).style.backgroundColor="green"
              document.getElementById("Pump_"+StepCount).value="true"
           }else {
              document.getElementById("ButPUMP_"+StepCount).style.backgroundColor="red"
              document.getElementById("Pump_"+StepCount).value="false"
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].VAC){
           if (myObj.LEVELS[LevelCount].STEPS[Steps].VAC == "ON"){
             document.getElementById("ButVAC_"+StepCount).style.backgroundColor="green"
              document.getElementById("Vac_"+StepCount).value="true"
           }else {
              document.getElementById("ButVAC_"+StepCount).style.backgroundColor="red"
              document.getElementById("Vac_"+StepCount).value="false"
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].SV1){
           document.getElementById("Sv1_"+StepCount).value=myObj.LEVELS[LevelCount].STEPS[StepCount].SV1
        }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].SV2){
           document.getElementById("Sv2_"+StepCount).value=myObj.LEVELS[LevelCount].STEPS[StepCount].SV2
        }
        if (myObj.LEVELS[LevelCount].STEPS[Steps].LOOP){
           document.getElementById("Loop_"+StepCount).value=myObj.LEVELS[LevelCount].STEPS[StepCount].LOOP
        }

        if (myObj.LEVELS[LevelCount].STEPS[Steps].TXT){
           document.getElementById("Notice_"+StepCount).value = myObj.LEVELS[LevelCount].STEPS[StepCount].TXT
        }
        if(myObj.LEVELS[LevelCount].STEPS[Steps].SRC){
          var testString= myObj.LEVELS[LevelCount].STEPS[Steps].SRC
          var resultString=myObj.LEVELS[LevelCount].STEPS[Steps].SRC.replace("slide","thumb")
          if (testString.includes(".faL")){resultString="img/Backgrounds/movieicon.jpg"}
          if (testString.includes(".faK")){resultString="img/Backgrounds/audioicon.jpg"}
           document.getElementById( "Image_"+StepCount).value =  myObj.LEVELS[LevelCount].STEPS[Steps].SRC
           document.getElementById("pic_"+StepCount).src = resultString
        }
        AddRecord()
        StepCount++
        Steps++
        }
   LevelCount++
  }
}




