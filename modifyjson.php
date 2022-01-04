<?php
include "Access.php";


//Load file
if(isset($_POST['mySelect'])){
	if($_POST['mySelect']!='NOFILE'){
		$filepath = './uploads/'.$_POST['mySelect'];
	}
}
if (file_exists($filepath)) {
    		$myJSON = file_get_contents($filepath);

//debug print_r($xml);
	} else {
    		exit('Failed to open file.Name '.$filepath );
}
?>
<html>
<head>
<title>JSON Constructor</title>
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
<link rel="stylesheet" type="text/css"  href="data/JsonConstruct.css">
<script>
var myJSON = <?php $myJSON = trim(preg_replace('/\s+/', ' ', $myJSON)); echo '\''.$myJSON.'\''; ?> ;
</script>
<script src="data/modifyjson.js"></script>
</head>
<body onload=Initialise()>
<div id="Title">
Please Enter in your Program
</div>
<form action="CommitUpload.php" method="post" id="MainForm">
<div id="FormHeader">
<input type="hidden" name="pass" value="<?php echo $_POST['pass']; ?>">
<input type="hidden" name="JSONtext" id="JSONtext" value="">
FileName:<input type="textbox" id="filename" name="FileName" class="textfield" value=<?php echo substr($_POST['mySelect'],0,-5);?>> </form>
Program:<input type="textbox" id="Program" name="Program"  class="textfield" oninput=updateJSON()>
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
    echo '" onclick=UpdateText('.$f.','.$i.',"'.$linksrc.'","';
    echo $src.'") id="imagef'.$f.'i'.$i.'" style="width:20%;display:inline;border-style:solid;border-width:5px;border-color:transparent"></div>';
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
</body>
</html>