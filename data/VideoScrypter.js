var Step=900/10   //svg width in pixels/duration in seconds
var Data=[]
var GraphData=[]
Data[0]=0

GraphData[0]=200


function  myShow(myObj){
 var x = myObj.querySelectorAll("img")
 myObj.style.height="90%"
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
        myObj.style.height="20%"
        myObj.style.width="20%"
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
       document.getElementById("FileSelectBox").style.display="inline"
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

}

function UpdateTime(){
   myVideo=document.getElementById("vid")
   document.getElementById("vidSeekAll").value=myVideo.currentTime
   var mins=~~(myVideo.currentTime/60)
   var secs=~~(myVideo.currentTime-mins)
   if(secs<10){secs="0"+secs}
   var frames=~~((myVideo.currentTime%1)*30)
   if (frames<10){frames="0"+frames}
   document.getElementById("vidTime").value=mins+":"+secs+"."+frames
   document.getElementById( "vidSeekSegment").value=(myVideo.currentTime%1)*30
   var circle=document.getElementById("cursor1")
   x=myVideo.currentTime*Step
   circle.setAttributeNS(null, "cx", x)
   y=GraphData[Math.round(x)]?GraphData[Math.round(x)]:y
   circle.setAttributeNS(null, "cy", y)

}

function UpdateControls(){
  myVideo=document.getElementById("vid")
  document.getElementById("vidSeekAll").max=myVideo.duration
  Step=900/myVideo.duration

}

function LoadVid(s){
  document.getElementById("FileSelectBox").style.display="none"
  myVideo=document.getElementById("vid")
  myVideo.src=s.dataset.link
}

function Pause(){
  myVideo=document.getElementById("vid")
  if(myVideo.paused){
    myVideo.play()
  }else{
    myVideo.pause()
  }
}

function vidRate(x) {
 myVideo=document.getElementById("vid")
 myVideo.playbackRate=x.value

}

function vidSeekAll(x){
  myVideo=document.getElementById("vid")
  myVideo.currentTime=x.value
}

function vidSeekSegment(x){
   myVideo=document.getElementById("vid")
   myVideo.pause()
   myVideo.currentTime=myVideo.currentTime-(myVideo.currentTime%1)+(x.value/30)
}

function Set(){
    var myTable = document.getElementById('jsonTable');
    var selectedRows = new Array()
    var timex=Math.round(document.getElementById( "vid").currentTime*Step)
    //check to see if any rows are highlighted
    n=0
    for (i = 1; i < myTable.rows.length; i++) {
      if(myTable.rows.item(i).style.background=="red"){
        selectedRows[n]=i
        n++
      }
    }
    if(n>0){
      for(i=0;i<selectedRows.length;i++){
        if(selectedRows[i]%2){
          myTable.rows.item(selectedRows[i]).style.background="pink"
        }else{
          myTable.rows.item(selectedRows[i]).style.background="white"
        }
        var objCells = myTable.rows.item(selectedRows[i]).cells;
        objCells.item(1).innerHTML=document.getElementById( "ActivitySelect").options[document.getElementById( "ActivitySelect").selectedIndex].value
        objCells.item(2).innerHTML=document.getElementById( "PositionSelect").options[document.getElementById( "PositionSelect").selectedIndex].value
        Data[timex]=document.getElementById( "PositionSelect").options[document.getElementById( "PositionSelect").selectedIndex].value
      }
    }else{
// Insert a row in the table at the last row
var newRow   = myTable.insertRow(-1);
newRow.setAttribute("onclick","modifythis(this)")
// Insert time
var newCell  = newRow.insertCell(0);
var newTime  = document.createTextNode(document.getElementById( "vidTime").value);
newCell.appendChild(newTime);
//insert activity
newCell  = newRow.insertCell(1);
newAct  = document.createTextNode(document.getElementById( "ActivitySelect").options[document.getElementById( "ActivitySelect").selectedIndex].value);
newCell.appendChild(newAct);
//insert position
newCell  = newRow.insertCell(2);
newText  = document.createTextNode(document.getElementById( "PositionSelect").options[document.getElementById( "PositionSelect").selectedIndex].value);
newCell.appendChild(newText);
Data[timex]=newText.data
txt=""
previ=0
for(i=0;i<901;i++){
  if(Data[i]){
    if(i>0){
       for(g=1;g<=(i-previ);g++){
         GraphData[previ+g]=CalcAmplitude(200-(Data[previ]*20),200-(Data[i]*20),i-previ,g)
       }
    previ=i
    }
  }
}
var lastData=0
for(g=0;g<901;g++){
  lastData=GraphData[g]?GraphData[g]:lastData
  txt+=" "+g+","+lastData
}
line=document.getElementById("graphline")
line.setAttributeNS(null, "points", txt)

}
}

function submitData(){
  var obj = new Object()
  var myTable=document.getElementById("jsonTable")
  // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
  for (i = 1; i < myTable.rows.length; i++) {
      // GET THE CELLS COLLECTION OF THE CURRENT ROW.
      var objCells = myTable.rows.item(i).cells;
      obj[i]={time:objCells.item(0).innerHTML, act:objCells.item(1).innerHTML, pos:objCells.item(2).innerHTML}
  }


  var JSONFilename = document.getElementById("vid").src
  res=JSONFilename.split("/")
  obj[0]={file:JSONFilename}
  JSONFilename = "/uploads/Scrypts/"+document.getElementById("vidfilename").value+".json"
  document.getElementById("JSONName").value=JSONFilename
  var myJSON=JSON.stringify(obj)
  document.getElementById("JSONString").value=myJSON
  document.getElementById("SubmitForm").submit()
}

function modifythis(x){
  x.style.background="red"
}

function CalcAmplitude(O, N, TotalTime, CurrentTime){
  Value = N + ((O-N)/2)*(1 + Math.cos(CurrentTime*Math.PI/TotalTime));
  return Value;
}

function doc_keyUp(e) {
        // this would test for whichever key is 32 and the ctrl key at the same time
    switch (e.keyCode) {
        case 39:
                //on "right" step forward
                myVideo=document.getElementById("vid")
                myVideo.currentTime+=0.033
                break;
        case 37:
             //on "left" step back
             myVideo=document.getElementById("vid")
             myVideo.currentTime-=0.033
             break;
        case 96:
        case 48:
             //on "0" set position to 0
             document.getElementById("PositionSelect").value = 0
             Set()
             break;
        case 97:
        case 49:
             //on "1" set position to 1
             document.getElementById("PositionSelect").value = 1
             Set()
             break;
        case 98:
        case 50:
             //on "2" set position to 2
             document.getElementById("PositionSelect").value = 2
             Set()
             break;
        case 99:
        case 51:
             //on "3" set position to 3
             document.getElementById("PositionSelect").value = 3
             Set()
             break;
        case 100:
        case 52:
             //on "4" set position to 4
             document.getElementById("PositionSelect").value = 4
             Set()
             break;
        case 101:
        case 53:
             //on "5" set position to 5
             document.getElementById("PositionSelect").value = 5
             Set()
             break;
        case 102:
        case 54:
             //on "6" set position to 6
             document.getElementById("PositionSelect").value = 6
             Set()
             break;
        case 103:
        case 55:
             //on "7" set position to 7
             document.getElementById("PositionSelect").value = 7
             Set()
             break;
        case 104:
        case 56:
             //on "8" set position to 8
             document.getElementById("PositionSelect").value = 8
             Set()
             break;
        case 105:
        case 57:
             //on "9" set position to 9
             document.getElementById("PositionSelect").value = 9
             Set()
             break;
        default:

             break;
    }

}
// register the handler
document.addEventListener('keyup', doc_keyUp, false);