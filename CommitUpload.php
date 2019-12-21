<?php
include "Access.php";
if(!accessgrant($_POST['pass'])){
  die("no access");
}
session_start();
if (isset($_POST['FileName'])){
   $uploadfile = './uploads/'.$_POST['FileName'].'.json';
}
if(isset($_POST['mySelect'])){
	if($_POST['mySelect']!='NOFILE'){
		$uploadfile = './uploads/'.$_POST['mySelect'];
	}
}
//load filename to session
$_SESSION['uploadfile'] = $uploadfile;
$_SESSION['DeviceAddress']=$_POST['deviceaddress'];
$_SESSION['pass']=$_POST['pass'];

echo '

<head>
<title>File Load</title>
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
	       background-image: url(img/Backgrounds/PinkBG.jpg );
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
    </head><body>';

if(isset($_FILES) && !(isset($_POST['FileName']))){
if(isset($_POST['mySelect'])){
echo'<div id="controls">File is valid, ready to go.
             Click <a href="ImagenateRun.php">here</a> to RUN
             </div><div id="background"></div>';
}
}

if(isset($_POST['FileName'])){
 echo '
<head>
<title>File Load</title>
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
';

$Level = "";
$FirstStep = True;
$s1=$s2=$s3=$s4=$vac=$playonce=$pump=$tens='off';
$mod=$freq=$pulse=$sv1=$sv2=$txt=$loop=$img="";
if (isset($_POST['FileName'])){

     $myString = '{"NAME":"'.$_POST['Program'].'", "LEVELS":[';
     $StepCount = 0;

while ($StepCount < count($_POST['Level'])){
  if ($_POST['Level'][$StepCount]!=$Level){
      if ($Level != ""){
          $myString = $myString.']}, ';
      }
      $Level = $_POST['Level'][$StepCount];
       $FirstStep = True;
       $myString = $myString.'{"TYPE":"'.$_POST['Level'][$StepCount].'", "REPEAT":"'.$_POST['Repeat'][$StepCount].'", "STEPS":[';
  }
  if ($FirstStep){
  $myString = $myString.'{';
  $FirstStep = False;
  }else{
  $myString = $myString.',{';
  }
  if (isset($_POST['Delay'][$StepCount])){
    $myString = $myString.'"DELAY":"'.$_POST['Delay'][$StepCount].'", ';
  }

  if (isset($_POST['S1'][$StepCount])){
    if($StepCount==0||$_POST['S1'][$StepCount]!=$_POST['S1'][$StepCount-1]){
      if ($_POST['S1'][$StepCount]== "true"){
            $myString = $myString.'"S1":"ON", ';
            $s1 = "on";
       }else{
        $myString = $myString.'"S1":"OFF", ';
        $s1 = "off";
       }
    }
      }
  if (isset($_POST['S2'][$StepCount])){
    if($StepCount==0||$_POST['S2'][$StepCount]!=$_POST['S2'][$StepCount-1]){
      if ($_POST['S2'][$StepCount]== "true"){
            $myString = $myString.'"S2":"ON", ';
            $s1 = "on";
       }else{
        $myString = $myString.'"S2":"OFF", ';
        $s1 = "off";
       }
    }
  }
    if (isset($_POST['S3'][$StepCount])){
      if($StepCount==0||$_POST['S3'][$StepCount]!=$_POST['S3'][$StepCount-1]){
      if ($_POST['S3'][$StepCount]== "true"){
            $myString = $myString.'"S3":"ON", ';
            $s1 = "on";
       }else{
        $myString = $myString.'"S3":"OFF", ';
        $s1 = "off";
       }
    }
  }
    if (isset($_POST['S4'][$StepCount])){
      if($StepCount==0||$_POST['S4'][$StepCount]!=$_POST['S4'][$StepCount-1]){
      if ($_POST['S4'][$StepCount]== "true"){
            $myString = $myString.'"S4":"ON", ';
            $s1 = "on";
       }else{
        $myString = $myString.'"S4":"OFF", ';
        $s1 = "off";
       }
      }
  }
  if ($_POST['Sv1'][$StepCount]!= $sv1){
    $myString = $myString.'"SV1":"'.$_POST['Sv1'][$StepCount].'", ';
     $sv1 = $_POST['Sv1'][$StepCount];
  }
  if ($_POST['Sv2'][$StepCount]!= $sv2){
    $myString = $myString.'"SV2":"'.$_POST['Sv2'][$StepCount].'", ';
     $sv2 = $_POST['Sv2'][$StepCount];
  }
 if (isset($_POST['Playonce'][$StepCount])){
      if($StepCount==0||$_POST['Playonce'][$StepCount]!=$_POST['Playonce'][$StepCount-1]){
      if ($_POST['Playonce'][$StepCount]== "true"){
            $myString = $myString.'"PLAYONCE":"ON", ';
            $playonce = "on";
       }else{
        $myString = $myString.'"PLAYONCE":"OFF", ';
        $playonce = "off";
       }
      }
  }

  if ($_POST['Notice'][$StepCount]!= $txt){
    $myString = $myString.'"TXT":"'.$_POST['Notice'][$StepCount].'", ';
    $txt = $_POST['Notice'][$StepCount];
  }
     if (isset($_POST['Vac'][$StepCount])){
       if($StepCount==0||$_POST['Vac'][$StepCount]!=$_POST['Vac'][$StepCount-1]){
      if ($_POST['Vac'][$StepCount]== "true"){
            $myString = $myString.'"VAC":"ON", ';
            $s1 = "on";
       }else{
        $myString = $myString.'"VAC":"OFF", ';
        $s1 = "off";
       }
       }
  }

    if (isset($_POST['Pump'][$StepCount])){
      if($StepCount==0||$_POST['Pump'][$StepCount]!=$_POST['Pump'][$StepCount-1]){
      if ($_POST['Pump'][$StepCount]== "true"){
            $myString = $myString.'"PUMP":"ON", ';
            $s1 = "on";
       }else{
        $myString = $myString.'"PUMP":"OFF", ';
        $s1 = "off";
       }
      }
  }
    $tensupdate=false;

  if ($_POST['Mod'][$StepCount]!= $mod){
     $mod = $_POST['Mod'][$StepCount];
     $tensupdate = true;
     $tens = "on";
  }
  if ($_POST['Freq'][$StepCount]!= $freq){
     $freq = $_POST['Freq'][$StepCount];
     $tensupdate = true;
     $tens = "on";
  }
  if ($_POST['Pulse'][$StepCount]!= $pulse){
     $pulse = $_POST['Pulse'][$StepCount];
     $tensupdate = true;
     $tens = "on";
  }
  if (isset($_POST['Tens'][$StepCount])){
    if($StepCount==0||$_POST['Tens'][$StepCount]!=$_POST['Tens'][$StepCount-1]){
      if ($_POST['Tens'][$StepCount]== "true"){
            $tensupdate=true;
            $tens = "on";
       }else{
        $tensupdate = true;
        $tens = "off";
       }
      }
  }

  if($tensupdate ){
      if($tens=='on'){$myString = $myString.'"TENS":"ON", ';}
      else{$myString = $myString.'"TENS":"OFF", ';}
      $myString = $myString.'"MOD":"'.$_POST['Mod'][$StepCount].'", ';
      $myString = $myString.'"FREQ":"'.$_POST['Freq'][$StepCount].'", ';
      $myString = $myString.'"PULSE":"'.$_POST['Pulse'][$StepCount].'", ';
  }


  if ($_POST['Loop'][$StepCount]!= $loop){
    $myString = $myString.'"LOOP":"'.$_POST['Loop'][$StepCount].'", ';
     $loop = $_POST['Loop'][$StepCount];
  }
   if (isset($_POST['Image'][$StepCount])){
    $myString = $myString.'"SRC":"'.$_POST['Image'][$StepCount].'"}';

  }else{
$myString = $myString.'"}';
}
$StepCount ++;
}
$myString = $myString.']}]}';

$filename = $uploadfile ;
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

    fclose($handle);

}
}

?>
