<?php
include "Access.php";

if (isset($_POST['FileName'])){                //if recieved by JSONConstruct.php
   $uploadfile = './uploads/'.$_POST['FileName'].'.json';
}
if(isset($_POST['mySelect'])){             //if recieved by imagenate.php
	if($_POST['mySelect']!='NOFILE'){
		$uploadfile = './uploads/'.$_POST['mySelect'];
	}
}

//load filename to session
$_SESSION['uploadfile'] = $uploadfile;
if (isset($_POST['deviceaddress'])){$_SESSION['DeviceAddress']=$_POST['deviceaddress'];}
if (isset($_POST['pass'])){$_SESSION['pass']=$_POST['pass'];}

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

if(isset($_FILES) && !(isset($_POST['FileName']))){   //if recieved by imagenate.php
if(isset($_POST['mySelect'])){
echo'<div id="controls">File is valid, ready to go.
             Click <a href="ImagenateRun.php">here</a> to RUN
             </div><div id="background"></div>';
}
}

if(isset($_POST['FileName'])){     //if recieved by JSONConstruct.php
 echo '
<div id="Title">
';
$somecontent = $_POST['JSONtext'];
$filename = $uploadfile ;
$errorflag=0;

    if (!$handle = fopen($filename, 'w')) {
         echo "Cannot open file ($filename)";
         $errorflag=1;
         exit;
    }

    // Write $somecontent to our opened file.
    if (fwrite($handle, $somecontent) === FALSE) {
        echo "Cannot write to file ($filename)";
        $errorflag=1;
        exit;
    }

    if($errorflag){
      echo 'Click <a href="Imagenate.php">here</a> to return home
             </div><div id="background"></div>';
    }else{
      echo  "Success, wrote to file ($filename)<br>";
      echo 'File is valid, and was successfully uploaded.</div>
             <div id="controls">
             Click <a href="ImagenateRun.php">here</a> to RUN
             </div><div id="background"></div>';

    fclose($handle);

}
}

if(isset($_POST['JSONName'])){                  //if recieved by VideoScrypter.php
   $filename = ".".$_POST['JSONName'] ;
   $somecontent = $_POST['JSONString'];


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
             Click <a href="Imagenate.php">here</a> to return home
             </div><div id="background"></div>';

    fclose($handle);
}
?>
