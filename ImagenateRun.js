var requestHstack = []
var PreviousTime
var timerId
var myObj = JSON.parse(myJSON)
var NewResourceFlag = true
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
var FailCount=0
function FailedLoad(){
    FailCount++
    console.log(FailCount+"failed loads")
    RequestHTML()
}

function RequestHTML(){
    var date = new Date()
    PreviousTime = date.getTime()
    if(requestHstack.length > 0){
      if(timerId){clockStart(document.getElementById("Pause"))}
      var myReturn = document.getElementById("ReturnHTML");
      myReturn.data =  requestHstack.shift()
      console.log("attempting to load:"+ myReturn.data)
      var clone = myReturn.cloneNode(true);
      var parent = myReturn.parentNode;
      parent.removeChild(myReturn );
      parent.appendChild(clone );
    }else{
      var imageP
      if(imageP==null){
      if(!timerId){
        PreviousTime = date.getTime()
        console.log('previos time set to'+PreviousTime)
        timerId = setTimeout(update, 1000)
      }
      }
    }
}

function doc_keyUp(e) {
        // this would test for whichever key is 32 and the ctrl key at the same time
    switch (e.keyCode) {
        case 32:
                //on "space" go to next level
                NextLevel();
                break;
        case 13:
             //on "enter" toggle clock start/stop
             clockStart(document.getElementById("Pause"));
             break;
        case 86:
             // on "v" toggle voice on/off
             document.getElementById("AudioOn").checked = !document.getElementById("AudioOn").checked;
             if(document.getElementById("AudioOn").checked){
             document.getElementById("Notice").style.display="none"
             }else{
                document.getElementById("Notice").style.display="block"
             }
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
             //on anything else skip to next step
             var date = new Date()
             PreviousTime=date.getTime() - 3600000
             update()
             break;
    }

}
// register the handler
document.addEventListener('keyup', doc_keyUp, false);

function NextLevel(){
        StepCount = 0
        RepeatCount = 0
        Delay = 0
        LevelCount = document.getElementById("LevelSelect" ).selectedIndex + 1
        if(LevelCount>=myObj.LEVELS.length){LevelCount = 0}
        document.getElementById("LevelSelect" ).selectedIndex = LevelCount
        if(typeof myObj.LEVELS[LevelCount].STEPS[0].TXT !== 'undefined'){
                  document.getElementById("Notice").innerHTML = myObj.LEVELS[LevelCount].STEPS[0].TXT
                  if(document.getElementById("AudioOn").checked){responsiveVoice.speak(myObj.LEVELS[LevelCount].STEPS[StepCount].TXT, document.getElementById("ChooseVoice").value)}
                  }
        document.getElementById("background").style.backgroundImage = "url( "+myObj.LEVELS[LevelCount].STEPS[0].SRC+")"
        document.getElementById("preload_src").href =  myObj.LEVELS[LevelCount].STEPS[0].SRC
        ImageProgress()
}

function S1On(){
  document.getElementById("s1").checked = true
  if(document.getElementById("NoHardware").checked != true){
    requestHstack.push("http://" + DeviceIP + "/s1on")
  }
}

function S1Off(){
  document.getElementById("s1").checked = false
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/s1off")
}
}

function S2On(){
  document.getElementById("s2").checked = true
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/s2on")
}
}

function S2Off(){
  document.getElementById("s2").checked = false
 if(document.getElementById("NoHardware").checked != true){
   requestHstack.push("http://" + DeviceIP + "/s2off")
  }
  }

function S3On(){
  document.getElementById("s3").checked = true
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/s3on")
  }
}

function S3Off(){
  document.getElementById("s3").checked = false
 if(document.getElementById("NoHardware").checked != true){
   requestHstack.push("http://" + DeviceIP + "/s3off")
 }
 }

function S4On(){
  document.getElementById("s4").checked = true
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/s4on")
 }
 }

function S4Off(){
  document.getElementById("s4").checked = false
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/s4off")
 }
 }
function PLAYONCEOn(){
  document.getElementById("myAudio").loop=false
}
function PLAYONCEOff(){
  document.getElementById("myAudio").loop=true
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

function Volt(val){
  document.getElementById("volt").value = val
}

function TensOn(){
  document.getElementById("tens").checked = true
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/tenson?m=" + document.getElementById("mod").value + "&f=" + document.getElementById("freq").value + "&p=" + document.getElementById("pulse").value + "&v=" + document.getElementById("volt").value)
 }
 }

function TensOff(){
  document.getElementById("tens").checked = false
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/tensoff")
}
}

function PumpOn(Limit){
  if (Limit){
      url = "http://" + DeviceIP + "/pumpon?value=" + Limit ;
  } else {
     url = "http://" + DeviceIP + "/pumpon";
  }
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push(url)
  }
 document.getElementById("pump").checked = true
}

function PumpOff(){
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/pumpoff")
  }
 document.getElementById("pump").checked = false
}

function VacOn(Limit){
  if (Limit){
      url = "http://" + DeviceIP + "/vacon?value=" + Limit ;
  } else {
     url = "http://" + DeviceIP + "/vacon";
  }
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push(url)
  }
 document.getElementById("vac").checked = true
}

function VacOff(){
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/vacoff")
  }
  document.getElementById("vac").checked = false
}
function Servo1(value){
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/servo1?pos=" + value)
  }
 document.getElementById("sv1").value = value
}

function Servo2(value){
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/servo2?pos=" + value)
  }
 document.getElementById("sv2").value = value
}

function Loopinit(value){
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://"+ DeviceIP + "/loop?" + value)
  }
 document.getElementById("looptxt").value = value
}

function setMaxVolts(x){
  if(document.getElementById("NoHardware").checked != true){
    requestHstack.push("http://" + DeviceIP + "/tensmaxvolts?v=" + x.value)
  }
}

var LevelCount = 0
var StepCount = 0
var RepeatCount = 0

SetNextSrc(myObj.LEVELS[0].STEPS[0].SRC)
ImageProgress()
var Delay =  0

function update() {
  //update clock
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


    //check for end of level
  if (StepCount < myObj.LEVELS[LevelCount].STEPS.length){
     NewTime = date.getTime() - Delay
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
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].PLAYONCE){
           if (myObj.LEVELS[LevelCount].STEPS[StepCount].PLAYONCE == "ON"){
              PLAYONCEOn()
           }else {
                 PLAYONCEOff()
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
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].VOLT){
           Volt(myObj.LEVELS[LevelCount].STEPS[StepCount].VOLT)
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
           SetBackground()
           //if not end of level load next image in level
           if ((StepCount+1) < myObj.LEVELS[LevelCount].STEPS.length){
               SetNextSrc(myObj.LEVELS[LevelCount].STEPS[StepCount+1].SRC)
               ImageProgress()
           //if end of level
           }else{
           //if level is to repeat load first image in level
              if ((myObj.LEVELS[LevelCount].REPEAT && (myObj.LEVELS[LevelCount].REPEAT > RepeatCount))|| document.getElementById("RepeatForever").checked){
                 SetNextSrc(myObj.LEVELS[LevelCount].STEPS[0].SRC)
                 ImageProgress()
              }else{
              //if not end of all levels, load first image from next level
                   if ((LevelCount+1) < myObj.LEVELS.length){
                      SetNextSrc(myObj.LEVELS[LevelCount+1].STEPS[0].SRC)
                      ImageProgress()
              //otherwise all levels and steps finished, load first image
                   }else{
                      SetNextSrc(myObj.LEVELS[0].STEPS[0].SRC)
                      ImageProgress()
                   }
              }
           }
        }
        if (typeof myObj.LEVELS[LevelCount].STEPS[StepCount].TXT !== 'undefined'){
           document.getElementById("Notice").innerHTML = myObj.LEVELS[LevelCount].STEPS[StepCount].TXT
           if(document.getElementById("AudioOn").checked){responsiveVoice.speak(myObj.LEVELS[LevelCount].STEPS[StepCount].TXT, document.getElementById("ChooseVoice").value)}
        }
        Delay = Number(myObj.LEVELS[LevelCount].STEPS[StepCount].DELAY)*1000
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
              document.getElementById("LevelSelect" ).selectedIndex = LevelCount
        }
        if (LevelCount >= myObj.LEVELS.length){
          LevelCount = 0
          RepeatCount = 0
          StepCount = 0
          if(timerId){clockStart(document.getElementById("Pause"))}
          document.getElementById("LevelSelect" ).selectedIndex = LevelCount
          return
        }
   document.getElementById("LevelSelect" ).selectedIndex = LevelCount

  }
  if(requestHstack.length == 0){
    if(!timerId){timerId = setTimeout(update, 1000)}
  }else{
     RequestHTML()
  }

}


function clockStart(x) {
  if(x.value=="Stop"){
    clockStop()
    x.value="Start"
  }else{
  console.log('start')
  x.value="Stop"
  if (timerId) return
  update()
  }
}

function clockStop() {
  console.log('stop')
  clearTimeout(timerId)
  timerId = null
}
var Imp = 0

function ImageProgress(){
      var elem = document.getElementById("myBar");
      var width = 1;
      var imageP = setInterval(frame, 10);
      preloadLink = document.getElementById("preload_src")
      function frame() {
               if (NewResourceFlag||width>99) {
               clearInterval(imageP);
               imageP=null;
               if(elem!=null){
               elem.style.width = '100%';}
               Imp = 0;
               } else {
               if(Imp>10){
                 width++
                 Imp=0
               }
        Imp++
        if(elem!=null){
        elem.style.width = width + '%';}
    }
  }
}

function ChangeLevel(){
        StepCount = 0
        RepeatCount = 0
        Delay = 0
        LevelCount = document.getElementById("LevelSelect" ).selectedIndex
        if(typeof myObj.LEVELS[LevelCount].STEPS[0].TXT !== 'undefined'){
                  document.getElementById("Notice").innerHTML = myObj.LEVELS[LevelCount].STEPS[0].TXT
                  if(document.getElementById("AudioOn").checked){responsiveVoice.speak(myObj.LEVELS[LevelCount].STEPS[StepCount].TXT, document.getElementById("ChooseVoice").value)}
                  }
        SetNextSrc(myObj.LEVELS[LevelCount].STEPS[0].SRC)
        ImageProgress()
        SetBackground()
        }

function SetNextSrc(source){
         preloadLink = document.getElementById("preload_src")
         if(!preloadLink){
           preloadLink=document.createElement("link")
           preloadLink.setAttribute("id",'preload_src')
           preloadLink.setAttribute("rel",'preload')
           preloadLink.setAttribute("href",'img\Backgrounds\slide\orangeBG.jpg')
           preloadLink.setAttribute("as",'image')
           document.getElementsByTagName("head")[0].appendChild(preloadLink)
           preloadLink.setAttribute("onload","NewResourceLoaded()")
           }
         if(source.indexOf(".faL")>0){
          preloadLink.setAttribute("as", "video")
          preloadLink.href=source
          NewResourceFlag=false
         }
         if(source.indexOf(".jaz")>0){
           preloadLink.href = source
           preloadLink.as= "image"
           NewResourceFlag=false
         }
         if(source.indexOf(".faK")>0){
           preloadLink.href = source
           preloadLink.setAttribute("as", "audio")
           NewResourceFlag=false
         }
}
function NewResourceLoaded(){
  NewResourceFlag=true
  console.log("preload complete")
  RequestHTML()
}
function SetBackground(){
         preloadLink = document.getElementById("preload_src")
         video = document.getElementById("myVideo")
         audio = document.getElementById("myAudio")
         //console.log(preloadLink)
         //console.log(preloadLink.getAttribute("as"))
         if(preloadLink.getAttribute("as")=="video"){
         // console.log("play video")
         document.getElementById("vid").style.display = "block"
         //document.addEventListener('keydown', () => { video.play(); })
         video.src = preloadLink.href
         video.type = "video/mp4"
         video.play()
        }
        if(preloadLink.getAttribute("as")=="audio"){
         // console.log("play audio")
         audio.src = preloadLink.href
         audio.load()
        }
        if(preloadLink.getAttribute("as")=="image"){
           //set picture
            document.getElementById("vid").style.display = "none"
            video.pause()
            document.getElementById("background").style.backgroundImage = "url( "+preloadLink.href+")"
         }
}

function ToggleAudio(audiocheck){
video = document.getElementById("myVideo")
audio = document.getElementById("myAudio")
console.log(!!audiocheck.checked)
if (!audiocheck.checked){
  audio.muted=true
  video.muted=true
}else{
  audio.muted=false
  video.muted=false
}
}

function initialise(){
 try{
  var Vs = responsiveVoice.getVoices()
 for (i=0;i<Vs.length;i++){
  var option = document.createElement("option")
  option.value=Vs[i].name
  option.text=Vs[i].name
  document.getElementById("ChooseVoice").appendChild(option)
 }
 }catch(e){}
 if(typeof myObj.LEVELS[0].STEPS[0].TXT !== 'undefined'){
  document.getElementById("Notice").innerHTML = myObj.LEVELS[0].STEPS[0].TXT
 }
 SetNextSrc(myObj.LEVELS[0].STEPS[0].SRC)
 SetBackground()
 for (i=0; i < myObj.LEVELS.length; i++){
 var x = document.getElementById("LevelSelect")
 var option = document.createElement("option")
 option.text = myObj.LEVELS[i].TYPE
 x.add(option)
 }
 console.log(DeviceIP)
 if(DeviceIP == "Enter device ip address"){document.getElementById("NoHardware").checked = true}
 clockStop()
}