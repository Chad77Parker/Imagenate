<?php
function accessgrant($pass = "false"){
  if($pass !="destiny".date("Ymd",time())){
  return false;
  }else{
    setcookie("grantaccess","true",time+3600);
    return true;
  }

if(isset($_COOKIE['grantaccess'])){
if($_COOKIE['grantaccess']=="true"){
  setcookie("grantaccess","true",time()+3600);
  return true;
}else{
  return false;
}
}
}
?>