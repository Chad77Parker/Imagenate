//Global Variables
var requestHstack = []
var PreviousTime
var timerId
var errorTimer
var myObj = JSON.parse(myJSON)
var NewResourceFlag = true
var FailCount=0
var LevelCount = 0
var StepCount = 0
var RepeatCount = 0
var Delay =  0
var Imp = 0
var HoldLevelIndex = false
var HoldLevelStep = 0
//menu and display functions
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

function doc_keyUp(e) {
   switch (e.keyCode) {
        case 46, 190:
                //on "." or "n" go to next level
                NextLevel();
                break;
        case 44, 188:
                 //on "," or "p" go to previous level
                 PreviousLevel()
                 break;
        case 72:
                 //on "h" go to hold
                 HoldLevel()
                 break;
        case 13:
             //on "enter" toggle clock start/stop
             clockToggle();
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
        case 68:
             //on "d" toggle no hardware on/off
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
        case 67:
             //on "c" go to finish
             FinishLevel()
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

}

function PreviousLevel(){
        StepCount = 0
        RepeatCount = 0
        Delay = 0
        LevelCount = document.getElementById("LevelSelect" ).selectedIndex - 1
        if(LevelCount<0){LevelCount = 0}
        document.getElementById("LevelSelect" ).selectedIndex = LevelCount
        if(typeof myObj.LEVELS[LevelCount].STEPS[0].TXT !== 'undefined'){
                  document.getElementById("Notice").innerHTML = myObj.LEVELS[LevelCount].STEPS[0].TXT
                  if(document.getElementById("AudioOn").checked){responsiveVoice.speak(myObj.LEVELS[LevelCount].STEPS[StepCount].TXT, document.getElementById("ChooseVoice").value)}
                  }
        document.getElementById("background").style.backgroundImage = "url( "+myObj.LEVELS[LevelCount].STEPS[0].SRC+")"
        document.getElementById("preload_src").href =  myObj.LEVELS[LevelCount].STEPS[0].SRC

}
 function FinishLevel(){
        StepCount = 0
        RepeatCount = 0
        Delay = 0
        LevelCount = myObj.LEVELS.length-1
        document.getElementById("LevelSelect" ).selectedIndex = LevelCount
        if(typeof myObj.LEVELS[LevelCount].STEPS[0].TXT !== 'undefined'){
                  document.getElementById("Notice").innerHTML = myObj.LEVELS[LevelCount].STEPS[0].TXT
                  if(document.getElementById("AudioOn").checked){responsiveVoice.speak(myObj.LEVELS[LevelCount].STEPS[StepCount].TXT, document.getElementById("ChooseVoice").value)}
                  }
        document.getElementById("background").style.backgroundImage = "url( "+myObj.LEVELS[LevelCount].STEPS[0].SRC+")"
        document.getElementById("preload_src").href =  myObj.LEVELS[LevelCount].STEPS[0].SRC

 }
 function HoldLevel(){
        if(!HoldLevelIndex){
          for(i=0;i<myObj.LEVELS.length;i++){
          if(myObj.LEVELS[i].TYPE=="hold"||myObj.LEVELS[i].TYPE=="Hold"||myObj.LEVELS[i].TYPE=="HOLD"){
            HoldLevelIndex=i
            HoldLevelReturn=LevelCount
            if(StepCount>0){
              HoldLevelStep=StepCount-1}
            else{
              HoldLevelStep=myObj.LEVELS[LevelCount-1].STEPS.length
            }
            StepCount = 0
            RepeatCount = 0
            LevelCount = HoldLevelIndex
            Delay = 0
            document.getElementById("LevelSelect" ).selectedIndex = HoldLevelIndex
            if(typeof myObj.LEVELS[LevelCount].STEPS[0].TXT !== 'undefined'){
                  document.getElementById("Notice").innerHTML = myObj.LEVELS[LevelCount].STEPS[0].TXT
                  if(document.getElementById("AudioOn").checked){responsiveVoice.speak(myObj.LEVELS[LevelCount].STEPS[StepCount].TXT, document.getElementById("ChooseVoice").value)}
                  }
            document.getElementById("background").style.backgroundImage = "url( "+myObj.LEVELS[LevelCount].STEPS[0].SRC+")"
            document.getElementById("preload_src").href =  myObj.LEVELS[LevelCount].STEPS[0].SRC

          break
          }
          }
        }else{
            HoldLevelIndex = false
            StepCount = HoldLevelStep
            LevelCount = HoldLevelReturn
            RepeatCount = 0
            Delay = 0
            LevelCount = HoldLevelReturn
            document.getElementById("LevelSelect" ).selectedIndex = HoldLevelReturn
            if(typeof myObj.LEVELS[LevelCount].STEPS[HoldLevelStep].TXT !== 'undefined'){
                  document.getElementById("Notice").innerHTML = myObj.LEVELS[LevelCount].STEPS[HoldLevelStep].TXT
                  if(document.getElementById("AudioOn").checked){responsiveVoice.speak(myObj.LEVELS[LevelCount].STEPS[StepCount].TXT, document.getElementById("ChooseVoice").value)}
                  }
            document.getElementById("background").style.backgroundImage = "url( "+myObj.LEVELS[LevelCount].STEPS[HoldLevelStep].SRC+")"
            document.getElementById("preload_src").href =  myObj.LEVELS[LevelCount].STEPS[HoldLevelStep].SRC

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
        SetBackground()
        }

function ImageProgress(Percentage){
      var elem = document.getElementById("myBar");
      if(elem!=null){
          elem.style.width = Percentage + '%';
          elem.innerHTML = Percentage + '%';
      }
}

function clockStart() {
 console.log('start')
 document.getElementById("RunningIndicator").style.backgroundColor="green"
 document.getElementById('Pause').value = "Stop"
 timerId = setTimeout(update, 1000)
}

function clockStop() {
  console.log('stop')
  document.getElementById("RunningIndicator").style.backgroundColor="red"
  document.getElementById('Pause').value = "Start"
  clearTimeout(timerId)
  timerId = null
}

function clockToggle() {
   if(timerId){
     clockStop()
   }else{
     clockStart()
   }
}

//running functions
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

function FailedLoad(){
    FailCount++
    console.log(FailCount+"failed loads")
    if(FailCount > 3){
      requestHstack.length = 0
      document.getElementById("NoHardware").checked = true
      FailCount=0
    }
    RequestHTML()
}

function SuccessLoad() {
  FailCount=0
  console.log("Successfully loaded HTML")
  RequestHTML()
}

function RequestHTML(){
    clearTimeout(errorTimer)
    var date = new Date()
    PreviousTime = date.getTime()
    if(document.getElementById("NoHardware").checked){requestHstack.length=0}
    if((requestHstack.length > 0)&&!document.getElementById("NoHardware").checked){
      clockStop()
      document.getElementById("RunningIndicator").style.backgroundColor="green"
      var myReturn = document.getElementById("ReturnHTML");
      myReturn.data =  requestHstack.shift()
      console.log("attempting to load:"+ myReturn.data)
      var clone = myReturn.cloneNode(true);
      var parent = myReturn.parentNode;
      parent.removeChild(myReturn );
      parent.appendChild(clone );
      errorTimer= setTimeout(FailedLoad,4000)
    }else{
      var imageP
      if(imageP==null){
      if(!timerId){
        PreviousTime = date.getTime()
        console.log('all html requests complete, previos time set to'+PreviousTime)
        clockStart()
      }
      }
    }
}








function update() {
  clockStop()
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

        if (myObj.LEVELS[LevelCount].STEPS[StepCount].TENS0){
           if (myObj.LEVELS[LevelCount].STEPS[StepCount].TENS0 == "ON"){
              Tens0On()
           }else {
                 Tens0Off()
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].TENS1){
           if (myObj.LEVELS[LevelCount].STEPS[StepCount].TENS1 == "ON"){
              Tens1On()
           }else {
                 Tens1Off()
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].TENS2){
           if (myObj.LEVELS[LevelCount].STEPS[StepCount].TENS2 == "ON"){
              Tens2On()
           }else {
                 Tens2Off()
           }
        }
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].SQZ){
           if (myObj.LEVELS[LevelCount].STEPS[StepCount].SQZ == "ON"){
              SqueezeOn()
           }else {
                 SqueezeOff()
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
        if (myObj.LEVELS[LevelCount].STEPS[StepCount].LOOP){
           Loopinit(myObj.LEVELS[LevelCount].STEPS[StepCount].LOOP)
        }

        if (myObj.LEVELS[LevelCount].STEPS[StepCount].SRC){
           SetBackground()
           //if not end of level load next image in level
           if ((StepCount+1) < myObj.LEVELS[LevelCount].STEPS.length){
               SetNextSrc(myObj.LEVELS[LevelCount].STEPS[StepCount+1].SRC)
               //if end of level
           }else{
           //if level is to repeat load first image in level
              if ((myObj.LEVELS[LevelCount].REPEAT && (myObj.LEVELS[LevelCount].REPEAT > RepeatCount))|| document.getElementById("RepeatForever").checked){
                 SetNextSrc(myObj.LEVELS[LevelCount].STEPS[0].SRC)
                 }else{
              //if not end of all levels, load first image from next level
                   if ((LevelCount+1) < myObj.LEVELS.length){
                      SetNextSrc(myObj.LEVELS[LevelCount+1].STEPS[0].SRC)
              //otherwise all levels and steps finished, load first image
                   }else{
                      SetNextSrc(myObj.LEVELS[0].STEPS[0].SRC)
                   }
              }
           }
        }
        if (typeof myObj.LEVELS[LevelCount].STEPS[StepCount].TXT !== 'undefined'){
           document.getElementById("Notice").innerHTML = myObj.LEVELS[LevelCount].STEPS[StepCount].TXT
           if(document.getElementById("AudioOn").checked){responsiveVoice.speak(myObj.LEVELS[LevelCount].STEPS[StepCount].TXT, document.getElementById("ChooseVoice").value)}
        }else{
           document.getElementById("Notice").innerHTML = ""
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
          clockStop()
          document.getElementById("LevelSelect" ).selectedIndex = LevelCount
          return
        }
   document.getElementById("LevelSelect" ).selectedIndex = LevelCount

  }
  if(requestHstack.length == 0){
    if(!timerId){clockStart()}
  }else{
     RequestHTML()
  }

}







function SetNextSrc(source){
         preloadLink = document.getElementById("preload_src")
         if(!preloadLink){
           preloadLink=document.createElement("link")
           preloadLink.setAttribute("id",'preload_src')
           preloadLink.setAttribute("rel",'preload')
           preloadLink.setAttribute("href",'img/Backgrounds/slide/ErrorBG.jpg')
           preloadLink.setAttribute("as",'image')
           document.getElementsByTagName("head")[0].appendChild(preloadLink)
           preloadLink.setAttribute("onload","NewResourceLoaded()")
           }

         xmlHTTP = new XMLHttpRequest();
         xmlHTTP.open( 'GET', source , true );
         xmlHTTP.responseType = 'arraybuffer';

         xmlHTTP.onload = function( e ) {
            var h = xmlHTTP.getAllResponseHeaders(),
            m = h.match( /^Content-Type\:\s*(.*?)$/mi ),
            mimeType = m?m[ 1 ]:'video/mp4';
            // Remove your progress bar or whatever here. Load is done.

            var blob = new Blob( [ this.response ], { type: mimeType } );
            newsrc = window.URL.createObjectURL( blob );
            if(source.indexOf(".faL")>0){
          preloadLink.setAttribute("as", "video")
          preloadLink.href=newsrc
          NewResourceFlag=false
         }
         if(source.indexOf(".jaz")>0){
           preloadLink.href = newsrc
           preloadLink.as= "image"
           NewResourceFlag=false
         }
         if(source.indexOf(".faK")>0){
           preloadLink.href = newsrc
           preloadLink.setAttribute("as", "audio")
           NewResourceFlag=false
         }
         };

         xmlHTTP.onprogress = function( e ) {
            if ( e.lengthComputable )
            completedPercentage = parseInt( ( e.loaded / e.total ) * 100 );
            ImageProgress(completedPercentage)
            // Update your progress bar here. Make sure to check if the progress value
            // has changed to avoid spamming the DOM.
            // Something like:
            // if ( prevValue != thisImage completedPercentage ) display_progress();
         };

    xmlHTTP.onloadstart = function() {
        // Display your progress bar here, starting at 0
        completedPercentage = 0;
        ImageProgress(completedPercentage)
    };

    xmlHTTP.onloadend = function() {
        // You can also remove your progress bar here, if you like.
        completedPercentage = 100;
        ImageProgress(completedPercentage)
    }

    xmlHTTP.send();



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
         document.getElementById("background").style.backgroundImage = "none"
         document.getElementById("vid").style.display = "block"
         document.addEventListener('keydown', () => { video.play(); })
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

//functions to run
function Tens0On(){
  document.getElementById("s1").checked = true
  if(document.getElementById("NoHardware").checked != true){
    requestHstack.push("http://" + DeviceIP + "/tens0on")
  }
}

function Tens0Off(){
  document.getElementById("s1").checked = false
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/tens0off")
}
}

function Tens1On(){
  document.getElementById("s2").checked = true
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/tens1on")
}
}

function Tens1Off(){
  document.getElementById("s2").checked = false
 if(document.getElementById("NoHardware").checked != true){
   requestHstack.push("http://" + DeviceIP + "/tens1off")
  }
  }

function Tens2On(){
  document.getElementById("s3").checked = true
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/tens2on")
  }
}

function Tens2Off(){
  document.getElementById("s3").checked = false
 if(document.getElementById("NoHardware").checked != true){
   requestHstack.push("http://" + DeviceIP + "/tens2off")
 }
 }

function SqueezeOn(){
  document.getElementById("s4").checked = true
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/sqzon")
 }
 }

function SqueezeOff(){
  document.getElementById("s4").checked = false
  if(document.getElementById("NoHardware").checked != true){
  requestHstack.push("http://" + DeviceIP + "/sqzoff")
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
