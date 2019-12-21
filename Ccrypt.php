<?php
define ("MainKey", "This is the main key to be used when encrypting files. The longer the Key the better. Be Warned loosing this key will mean encrypted files cannot be retrieved!");
function cryptfilename($data){
  $CTable = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789,._~!@$%^&*()#+-=?";
  $DTable = "mnbvcxzlkjhgfdsapoiuytrewq9876543210 QWERTYUIOPASDFGHBCJKLMNVXZ,._~!@$%^&*()#+-=?";
  $output = "";
  for ($d = 0; $d < strlen($data); $d++){
    $k = strpos($CTable,$data[$d]);
    $output = $output.$DTable[$k];

  }
  return $output;
}
function decryptfilename($data){
  $DTable = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789,._~!@$%^&*()#+-=?";
  $CTable = "mnbvcxzlkjhgfdsapoiuytrewq9876543210 QWERTYUIOPASDFGHBCJKLMNVXZ,._~!@$%^&*()#+-=?";
  $output = "";
  for ($d = 0; $d < strlen($data); $d++){
    $k = strpos($CTable,$data[$d]);
    $output = $output.$DTable[$k];

  }
  return $output;
}
function cryptfile($data,$key){

  $newdata = substr($data,0,strlen($key));
  $newdata = $newdata ^ $key;
  substr_replace($data,$newdata,0,strlen($key));
  return $data ;

}
function cryptheader($data,$key){

}
?>