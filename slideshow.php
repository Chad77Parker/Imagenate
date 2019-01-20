<?php
include "Access.php";
if(!accessgrant($_POST['pass'])){
  die("no access");
}
?>
<html>
<head>
<title>Create Slideshow</title>
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

    $imagefiles = array_slice(scandir('img/'.$value.'/slide'), 2);
    $i = 1;
    $images[$f][0]=$value;
    foreach($imagefiles as $imagevalue){
      $images[$f][$i]=$imagevalue;
      $i++;
    }
    $f++;

}
$Level = "";
$FirstStep = True;
$s1=$s2=$s3=$s4=$vac=$pump=$tens=$mod=$freq=$pulse=$sv1=$sv2=$txt=$loop=$img="";
$myString = '{"NAME":"Slideshow", "LEVELS":[';

     $LevelCount=0;
while ($LevelCount < count($dirs)){
       $Level = $dirs[$LevelCount];
       $myString = $myString.'{"TYPE":"'.decryptfilename($dirs[$LevelCount]).'", "REPEAT":"99", "STEPS":[';
        $StepCount = 1;
        $fStep = true;
        while($StepCount < count($images[$LevelCount])){
           if($images[$LevelCount][$StepCount]!="thumb" && $images[$LevelCount][$StepCount]!="slide"){
             if (!$fStep){$myString = $myString.', ';}
             $myString = $myString.'{"DELAY":"4", "SRC":"imagedecode.php?filename=img/'.$dirs[$LevelCount].'/slide/'.$images[$LevelCount][$StepCount].'", "TXT":"'.decryptfilename($dirs[$LevelCount]).'"}';
             //to update pics
             if(!file_exists('img/'.$dirs[$LevelCount].'/slide/'.$images[$LevelCount][$StepCount])){
             echo '<img src="image.php?image_name='.$images[$LevelCount][$StepCount].'&style=slide&image_path=img/'.$dirs[$LevelCount].'" >';
             //end update
             }
             $fStep = false;
           }
           ++$StepCount;
       }
       $myString = $myString.']}';
$LevelCount ++;
if($LevelCount < count($dirs)){$myString = $myString.',';}
}
$myString = $myString.']}';

$filename = "./uploads/Slideshow.json";
echo 'Json slideshow constructed</div><div id="Notice">';
$somecontent = $myString;
    if (!$handle = fopen($filename, 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }

    // Write $somecontent to our opened file.
    if (fwrite($handle, $somecontent) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }

    echo "Success, wrote to file ($filename)<br>";
    echo 'File is valid, and was successfully uploaded.</div>
             <div id="controls">
             Click <a href="ImagenateRun.php">here</a> to RUN
             </div><div id="background"></div>';
    $_SESSION['uploadfile'] = "./uploads/Slideshow.json";
    fclose($handle);
?>
</body>
</html>