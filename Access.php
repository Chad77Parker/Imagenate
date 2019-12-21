<?php
function accessgrant($pass = "false"){
  if($pass !="destiny".date("Ymd",time())){
  return false;
  }else{
    $_SESSION['pass']=$pass;
    return true;
  }

if(isset($_SESSION['pass'])){
if($_SESSION['pass']=="destiny".date("Ymd",time())){
  return true;
}else{
  return false;
}
}
}
?>