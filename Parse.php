<?php
/* include "Access.php";
if(!accessgrant($_POST['pass'])){
  die("no access");
}  */
?>
<html>
<head>
<title>File Parser</title>
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
        font-family: "Gloria Hallelujah", cursive;
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
        font-family: "Gloria Hallelujah", cursive;
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
        width:33%;
        height:30%
      }
      #background{
        position:absolute;
	      background: pink no-repeat fixed center;
	       background-image: url(img/Backgrounds/PinkBG.jpg);
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
</head>
<body>
<div id="Title">
<?php
include 'ccrypt.php';
$dirs = array_slice(scandir('img'), 2);
$f = 0;
foreach($dirs as $value){
    if($value!="Backgrounds"){
    $imagefiles = array_slice(scandir('img/'.$value.'/slide'), 2);
    $i = 1;
    $images[$f][0]=$value;
    foreach($imagefiles as $imagevalue){
      $images[$f][$i]=$imagevalue;
      $i++;
    }
    $f++;
    }
}
//Parse all images
$mp4changed=0;
$countimages=0;
$f=0;
$newthumb=0;
while($f<count($images)){
   $i=1;
   while($i<count($images[$f])){
       if(false){        //change to "true" to check for missing thumbnails and repair
       if(!file_exists('img/'.$images[$f][0].'/thumb/'.$images[$f][$i])){    //Check to see if thumbnails exist
         //if video file do this
         if(strpos(decryptfilename($images[$f][$i]),".mp4")>0){
              echo '<object data="thumbfromvideo.php?filename=img/'.$images[$f][0].'/slide/'.$images[$f][$i].'&thumbpath=img/'.$images[$f][0].'/thumb"></object>';
              echo decryptfilename($images[$f][$i]).'<br>img/'.$images[$f][0].'/slide/'.$images[$f][$i].'<br>';
         }
         if(strpos(decryptfilename($images[$f][$i]),".jpg")>0){
              echo '<img src="image.php?image_name='.$images[$f][$i].'&style=thumb&image_path=img/'.$images[$f][0].'/slide">';
              echo decryptfilename($images[$f][$i]).'<br>img/'.$images[$f][0].'/slide/'.$images[$f][$i].'<br>';
         }
         $newthumb++;
       }
     }
     if(false){   //change to "true" to Crypt files without changing encryption of filename
       if(filemtime('img/'.$images[$f][0].'/slide/'.$images[$f][$i])<(time()-86400)) {// if hasnt been modified today
         $myblobi = file_get_contents('img/'.$images[$f][0].'/slide/'.$images[$f][$i]);
         $newblobi = cryptfile($myblobi,MainKey);
         file_put_contents('img/'.$images[$f][0].'/slide/'.$images[$f][$i],$newblobi);
         $myblobi = file_get_contents('img/'.$images[$f][0].'/thumb/'.$images[$f][$i]);
         $newblobi = cryptfile($myblobi,MainKey);
         file_put_contents('img/'.$images[$f][0].'/thumb/'.$images[$f][$i],$newblobi);
       }
     }
     if(false) { //change to "true" to crypt mp4 files only
       if(strpos(decryptfilename($images[$f][$i]),".mp4")>0){
         $myblobi = file_get_contents('img/'.$images[$f][0].'/slide/'.$images[$f][$i]);
         $newblobi = cryptfile($myblobi,MainKey);
         file_put_contents('img/'.$images[$f][0].'/slide/'.$images[$f][$i],$newblobi);
         $mp4changed++;
       }
     }
   $i++;
   $countimages++;
 }
 $f++;
}
    echo 'Number of images '.$countimages.'. Number of folders checked'.$f.'.  Number of thumbs generated '.$newthumb.'.  Number of mp4s changed '.$mp4changed.'</div>
             <div id="controls">
             Click <a href="Imagenate.php">here</a> to return home.
             </div><div id="background"></div>';
?>
</body>
</html>