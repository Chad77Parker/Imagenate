<?php
session_start();
if (isset($_POST['FileName'])){

$uploadfile = './uploads/'.$_POST['FileName'].'.json';
$_SESSION['uploadfile'] = $uploadfile;
$_SESSION['DeviceAddress']=$_POST['deviceaddress'];
}

if(isset($_POST['mySelect'])){
	if($_POST['mySelect']!='NOFILE'){
		$uploadfile = './uploads/'.$_POST['mySelect'];
	}
}
//load filename to session
$_SESSION['uploadfile'] = $uploadfile;
$_SESSION['DeviceAddress']=$_POST['deviceaddress'];



if(isset($_FILES) && !(isset($_POST['FileName']))){
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

if(!(isset($_POST['mySelect']))){
if (strripos($_FILES['userfile']['name'],".json") !== false){
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
  echo'<div id="controls">File is valid, and was successfully uploaded.

             Click <a href="ImagenateRun.php">here</a> to RUN
             </div><div id="background"></div>';
	} else {
    		echo "Possible file upload attack!\n </div>";
	}
} else {
echo '<div id="controls">Not a JSON file </div>';
}
}else{
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
$s1=$s2=$s3=$s4=$vac=$pump=$tens=$mod=$freq=$pulse=$sv1=$sv2=$txt=$loop=$img="";
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
      if ($s1 != "on"){
            $myString = $myString.'"S1":"ON", ';
            $s1 = "on";
       }
  }else {
    if ($s1 != "off"){
      $myString = $myString.'"S1":"OFF", ';
      $s1 = "off";
    }
  }
  if (isset($_POST['S2'][$StepCount])){
      if ($s2 != "on"){
            $myString = $myString.'"S2":"ON", ';
            $s2 = "on";
       }
  }else {
    if ($s2 != "off"){
      $myString = $myString.'"S2":"OFF", ';
      $s2 = "off";
    }
  }
  if (isset($_POST['S3'][$StepCount])){
      if ($s3 != "on"){
            $myString = $myString.'"S3":"ON", ';
            $s3 = "on";
       }
  }else {
    if ($s3 != "off"){
      $myString = $myString.'"S3":"OFF", ';
      $s3 = "off";
    }
  }
  if (isset($_POST['S4'][$StepCount])){
      if ($s4 != "on"){
            $myString = $myString.'"S4":"ON", ';
            $s4 = "on";
       }
  }else {
    if ($s4 != "off"){
      $myString = $myString.'"S4":"OFF", ';
      $s4 = "off";
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
  if ($_POST['Notice'][$StepCount]!= $txt){
    $myString = $myString.'"TXT":"'.$_POST['Notice'][$StepCount].'", ';
    $txt = $_POST['Notice'][$StepCount];
  }
   if (isset($_POST['Vac'][$StepCount])){
       if ($vac != "on"){
            $myString = $myString.'"VAC":"ON", ';
            $vac = "on";
       }
   }else {
    if ($vac != "off"){
      $myString = $myString.'"VAC":"OFF", ';
      $vac = "off";
    }
  }

  if (isset($_POST['Pump'][$StepCount])){
     if ($pump != "on"){
            $myString = $myString.'"PUMP":"ON", ';
            $pump = "on";
       }
    }else {
    if ($pump != "off"){
      $myString = $myString.'"PUMP":"OFF", ';
      $pump = "off";
    }
  }
  if (isset($_POST['Tens'][$StepCount])){
       $tensupdate = false;
       if ($tens != "on"){
            $tensupdate = true;
            $tens = "on";

   }

  if ($_POST['Mod'][$StepCount]!= $mod){
    $myString = $myString.'"MOD":"'.$_POST['Mod'][$StepCount].'", ';
     $mod = $_POST['Mod'][$StepCount];
     $tensupdate = true;
  }
  if ($_POST['Freq'][$StepCount]!= $freq){
    $myString = $myString.'"FREQ":"'.$_POST['Freq'][$StepCount].'", ';
     $freq = $_POST['Freq'][$StepCount];
     $tensupdate = true;
  }
  if ($_POST['Pulse'][$StepCount]!= $pulse){
    $myString = $myString.'"PULSE":"'.$_POST['Pulse'][$StepCount].'", ';
     $pulse = $_POST['Pulse'][$StepCount];
     $tensupdate = true;
  }
  if($tensupdate ){
      $myString = $myString.'"TENS":"ON", ';
  }
  }else {
    if ($tens != "off"){
      $myString = $myString.'"TENS":"OFF", ';
      $tens = "off";
    }
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
