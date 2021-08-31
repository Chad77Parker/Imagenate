<?php
include "Access.php";

?>

<html>
<head>
      <title>Video Scrypter</title>
      <link href="data/VideoScrypter.css" rel="stylesheet" type="text/css" >
      <script src="data/VideoScrypter.js"></script>
</head>
<body>
      <div id="vidbox">
           <video autoplay muted loop controls ontimeupdate=UpdateTime() onloadedmetadata=UpdateControls() id="vid" src="http://115.70.114.10:81/ssl/frost/img/OkhushJ/slide/MCCLVBJxncZBbnvCmJcCxVZBmKmxxvnV.faL">
           </video>
      </div>

      <div id="controls">
           <input type="text" id="vidfilename" value="Enter name of Scrypt">
           <input type="button" value="Return Home" onclick="document.forms[1].submit();">
           <input id="vidPause" type="button" value="Pause" onClick=Pause()>
           <input id="vidTime" type="textbox">
           <input type="range" id="vidRate" min=".1" max="1" step="0.1" value="1"  onchange="vidRate(this)">
           Activity<select id="ActivitySelect">
                <option value="0">Hand</option>
                <option value="1">Mouth</option>
                <option value="2">Pussy</option>
                <option value="3">Butt</option>
                <option value="4">Spank</option>
           </select>
           Position<select id="PositionSelect">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
           </select>
           <input id="Set" type="button" value="Set" onClick=Set()>
           <br>
           <input type="range" min="0" max="10" step="0.0333" class="full" id="vidSeekAll"  oninput="vidSeekAll(this)">
           <br><br>
           <input type="range" min="0" max="30" step="1" class="full" id="vidSeekSegment" oninput="vidSeekSegment(this)">
           <br>
           <input id="vidSubmit" type="button" value="Submit" onClick=submitData()>
      </div>

<?php
include 'ccrypt.php';
$selectHTML = '<div id="filebox" onmouseover=myShow(this) onmouseout=myHide(this) onclick=myShow(this)>';
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

     if((strpos($images[$f][1],".faL")>0)&&(strpos($images[$f][1],".jpg")>0)){  //check if file is mp4
       $image_thumb='img/'.$images[$f][0].'/thumb/'.$images[$f][1];
       $src='imagedecode.php?filename='.$image_thumb;
     }elseif(strpos($images[$f][1],".faK")>0){  //check if file is mp3
       $image_thumb='img/Backgrounds/audioicon.jpg';
       $src=$image_thumb;
     }else{
       $image_thumb='img/'.$images[$f][0].'/thumb/'.$images[$f][1];
       $src = 'imagedecode.php?filename='.$image_thumb;
    }
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
echo $selectHTML;
?>
</div>

<div id="FileSelectBox" >
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
     if(strpos($images[$f][$i],".faL")>0){  //check if file is mp4
       $src = 'imagedecode.php?filename='.$image_thumb;
       $linksrc = $image_path.'/slide/'.$image_name;
      // $txtoverlay = decryptfilename($image_name);
       $image_path = $image_path.'/slide';
     }elseif(strpos($images[$f][$i],".faK")>0){ //check if file is mp3
       $src = 'img/Backgrounds/audioicon.jpg';
       $linksrc = $image_path.'/slide/'.$image_name;
       $txtoverlay = decryptfilename($image_name);
       $image_path = $image_path.'/slide/';
     }else{
       $src = 'imagedecode.php?filename='.$image_thumb;
       $linksrc = 'imagedecode.php?filename='.$image_path.'/slide/'.$image_name;
       $txtoverlay = "";
       if(!file_exists($image_thumb)){
        $src = "image.php?image_name=$image_name&style=$style&image_path=$image_path";
     // only if file doesn't exist call the on-the-fly creating file
    }
    }
    echo '<div class="container" style="width:20%;display:inline;"><div class="centered">'.$txtoverlay.'</div><img data_src="'.$src;
    echo '" onclick=LoadVid(this) data-link="'.$linksrc.'" id="imagef'.$f.'i'.$i.'" style="width:20%;display:inline;border-style:solid;border-width:5px;border-color:transparent"></div>';
    }
    $i++;
 }
 echo '</div>';
 $f++;
}

?>
</div>

      <div id="jsonbox">
           <table id="jsonTable">
                  <tr onclick=modifythis(this)>
                  <th>
                  Time
                  </th>
                  <th>
                  Action
                  </th>
                  <th>
                  Position
                  </th>
           </table>
      </div>

      <div id="submitbox">
           <form id="SubmitForm" action="CommitUpload.php" method="post" >
                 <input type="hidden" id="JSONName" name="JSONName">
                 <input type="hidden" id="JSONString" name="JSONString">
           </form>
      </div>

      <div id="imageselectOverlay" style="display:none; z-index:20"><img id="MainOverlay"></div>
      <div id="background"></div>
           <form action="imagenate.php" method="post" id="returnhomeform">
                 <input type="hidden" name="pass" value="<?php echo $pass;?>">
           </form>
      <div id="GraphOutput">
           <svg width="100%" height="100%" id="chart">
                <polyline id="graphline"
                         fill="none"
                         stroke="#0074d9"
                         stroke-width="3"
                         points="
                                 0,100
                                 900,100"></polyline>
                <circle id="cursor1" cx="30" cy="100" r="10" stroke="black" stroke-width="2" fill="red"></circle>
           </svg>
      </div>
</body>
</html>