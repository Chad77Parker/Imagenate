<?php
session_start();
$loggedin=false;
if(isset($_SESSION['pass'])){
if($_SESSION['pass']=="destiny".date("Ymd",time())){
  $loggedin= true;
}else{
  $loggedin = false;
}
}else{
  if(isset($_POST['pass'])){
    if($_POST['pass'] !="destiny".date("Ymd",time())){
  $loggedin = false;
  }else{
    $_SESSION['pass']=$_POST['pass'];
    $loggedin = true;
  }
  }
}
if(!$loggedin){
  die("no access");
}
?>