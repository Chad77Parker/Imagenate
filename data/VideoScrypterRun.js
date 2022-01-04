/*Description of flow
 *clock start button pushed
 *call update function
       -update clock display
       -if delay time has expired then
           -check json file and add any events to HStack and change image
           -if there are events in Hstack call RequestHTML()
           -RequestHTML if Hstack not empty
                -loads a html into an object, and the onload event calls RequestHTML() again
                -else, set timeout for 1 sec and call update()
       -set timeout for 1 sec and call update again

*/

//Global variables
var runTime=0
var Step=1
var myJSON
var NextStep=true
var mf=md=pf=pw=v=mfOld=mdOld=pfOld=pwOld=vOld=0
var NextStepSecs=timeOld=0
var connection
var FileSelectClickedFlag=false
var DataRX=true
var waitTimer
function initialise(){
setRanges()
DeviceIP=document.getElementById("DevIP").value
if(DeviceIP != "Enter Device IP Address"){
  startWSConnection()
}else{
  document.getElementById("NoHardware").checked=true
}
}

function startWSConnection(){
    connection = new WebSocket('ws://' + DeviceIP + ':81', ['arduino'])
  connection.onopen = function () {
  connection.send('Connect ' + new Date())
  }
connection.onerror = function (error) {
  console.log('WebSocket Error ', error)
}
connection.onmessage = function (e) {
  DataRx=true
  clearTimeout(waitTimer)
  myVideo.play()
  console.log('WebSocket Server: ', e.data)
}
connection.onclose = function () {
  myVideo.pause()
  document.getElementById("Pause").value="Start"
  console.log('WebSocket connection closed')
  //alert("Connection with Hardware lost!")
  setTimeout(startWSConnection,500)
}
}
//menu and display functions
function ChangeFile(x){
FileSelectClickedFlag=false
var xmlhttp = new XMLHttpRequest();
var url = x.options[x.selectedIndex].value;
url= "uploads/Scrypts/"+url

xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        myJSON = JSON.parse(this.responseText);
        document.getElementById("myVideo").src=myJSON[0].file
        Step=1
        runTime=0
        mf=12;md=128;pf=128;pw=50;v=100;
    }
};
xmlhttp.open("GET", url, true);
xmlhttp.send();
HideControls()
}

function ShowControls(){
   document.getElementById("controls").style.display = "block"
}

function HideControls(){
  if(!FileSelectClickedFlag){
   document.getElementById("controls").style.display = "none"
  }
}
function FileSelectClicked(){
   FileSelectClickedFlag=true
}
function ShowHideOutput(){
  var myDisplay = document.getElementById("output").style.display
  if (myDisplay == "block"){
        document.getElementById("output").style.display = "none"
  }else{
    document.getElementById("output").style.display = "block"
  }
}

function doc_keyUp(e) {
        // this would test for whichever key is 32 and the ctrl key at the same time
    switch (e.keyCode) {
        case 32:
                //on "space" go to next level

                break;
        case 13:
             //on "enter" toggle clock start/stop
             Pause()
             break;
        case 72:
             //on "h" toggle no hardware on/off
             document.getElementById("NoHardware").checked = !document.getElementById("NoHardware").checked;
             break;
        case 79:
             //on "o" toggle show output
             ShowHideOutput();
             break;
        case 82:
             // on "r" toggle repeat forever
             document.getElementById("RepeatForever").checked = !document.getElementById("RepeatForever").checked;
             break;
        default:

             break;
    }

}
// register the handler
document.addEventListener('keyup', doc_keyUp, false);


function Pause(){
  myVideo=document.getElementById("myVideo")
  if(myVideo.paused){
    myVideo.play()
    document.getElementById("Pause").value="Stop"
  }else{
    myVideo.pause()
    document.getElementById("Pause").value="Start"
  }
}

function vidRate(x) {
 myVideo=document.getElementById("myVideo")
 if (x.value<8){speed=0.1}
 else if(x.value>80){speed=1+((x.value-80)/20)}
 else{speed=x.value/80}
 myVideo.playbackRate=speed
 document.getElementById("SpeedDisplay").innerHTML=speed.toFixed(2)
 console.log("Playback speed changed to "+speed.toFixed(2)+"X")
}

//functions to run

function setMF(x){
    mf = x.value
    document.getElementById("ModF").value=(mf*0.04).toFixed(2) +"s"
    SendCurrentWSData()
}

function setMDC(x){
    md = x.value
    document.getElementById("ModDC").value=(100*md/255).toFixed() +"%"
    SendCurrentWSData()
}

function setPF(x){
    pf = x.value
    document.getElementById("PlsF").value=Math.pow(1.034, pf).toFixed() +"Hz"
    SendCurrentWSData()
}


function setPW(x){
    pw = x.value
    document.getElementById("PlsW").value=pw*2 +"uS"
    SendCurrentWSData()
}


function setV(x){
    v = x.value
    document.getElementById("Volt").value=(v*0.2).toFixed(1) +"V"
    SendCurrentWSData()
}

function setMaxVolts(x){
  JSONmessage='{"vm":"'+ x.value + '";}'
  if(document.getElementById("NoHardware").checked != true){
   connection.send(JSONmessage)
   console.log("Sent: "+JSONmessage)
  }
}

function time(ms) {
    return new Date(ms).toISOString().slice(11, -1);
}

function EndVid(x){
  if(document.getElementById("RepeatForever").checked){
     x.play()
     Step=1
     NextStep=true
  }
}

function UpdateTime(){
   myVideo=document.getElementById("myVideo")
   var mins=~~(myVideo.currentTime/60)
   var secs=~~(myVideo.currentTime-mins)
   if(secs<10){secs="0"+secs}
   var frames=~~((myVideo.currentTime%1)*30)
   if (frames<10){frames="0"+frames}
   document.getElementById("clock").innerHTML=mins+":"+secs+"."+frames

   
   if(NextStep && Object.keys(myJSON).length>Step){    //if next step true load new time to check
         NextStepTime=myJSON[Step].time.split(/[:.]+/)
         NextStepSecs=((Math.round(NextStepTime[0])+(Math.round(NextStepTime[1]))+(NextStepTime[2]/30))).toFixed(3)
         NextStep=false
         mfOld=mf;mdOld=md;pfOld=pf;pwOld=pw;vOld=v;
         timeOld=myVideo.currentTime
         switch(myJSON[Step].act){
         case "0":   //Hand.  Modify mf between 50 and 25
              document.getElementById("func").innerHTML="H"
              mf=Math.round(25-(25*myJSON[Step].pos/9))
              setRanges()
              break;
         case "1":   //Mouth. Modify md between 10 and 250
              document.getElementById("func").innerHTML="M"
              mf=12
              md=Math.round(10+(240*myJSON[Step].pos/9))
              setRanges()
              break;
         case "2":   //Pussy. Modify pf between 191 and 104, pw between 20 and 140
              document.getElementById("func").innerHTML="P"
              mf=255
              md=255
              pf=Math.round(191-(87*myJSON[Step].pos/9))
              pw=Math.round(20+(120*myJSON[Step].pos/9))
              setRanges()
              break;
         case "3":   //Butt. Modify pw between 40 and 240
              document.getElementById("func").innerHTML="B"
              mf=255
              md=255
              pw=Math.round(40+(200*myJSON[Step].pos/9))
              setRanges()
              break;
         case "4":   //Spank
              document.getElementById("func").innerHTML="S"

              setRanges()
              break;
         default:
         }
       SendCurrentWSData()
   }
   if(!NextStep && NextStepSecs<myVideo.currentTime){  //check if time has elapsed if there's another step
         NextStep=true
         Step+=1
   }
}

function SendCurrentWSData(){
   if(DataRX){
   JSONmessage='{"mf":"'+mf+'","md":"'+md+'","pf":"'+pf+'","pw":"'+pw+'","v":"'+v+'","t":"'+NextStepSecs+'"}'
   console.log("sent "+JSONmessage+". To be executed by time "+NextStepSecs)
   if(!document.getElementById("NoHardware").checked){
     connection.send(JSONmessage)
   }
   DataRx=false
   myVideo=document.getElementById("myVideo")
   if(!myVideo.paused){
    myVideo.pause()
   }
   }
   else{
     waitTimer=setTimeout(SendCurrentWSData,100)
   }
}

function setRanges(a=mf, b=md, c=pf, d=pw, e=v){
       document.getElementById("MFRange").value=a
       document.getElementById("ModF").value=(a*0.04).toFixed(2) +"s"
       document.getElementById("MDCRange").value=b
       document.getElementById("ModDC").value=(100*b/255).toFixed() +"%"
       document.getElementById("PFRange").value=c
       document.getElementById("PlsF").value=Math.pow(1.034, c).toFixed() +"Hz"
       document.getElementById("PWRange").value=d
       document.getElementById("PlsW").value=d*2 +"uS"
       document.getElementById("VRange").value=e
       document.getElementById("Volt").value=(e*0.2).toFixed(1) +"V"
}



