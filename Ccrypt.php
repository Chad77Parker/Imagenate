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
  $x = (int)(strlen($data)/strlen($key));
  $newKey = $key;
  while($x > 0){
    $newKey = $newKey.$key;
    $x--;
  }
  $newKey = substr($newKey,0,strlen($data));
  $newData = $data ^ $newKey;
  return $newData ;
  

}

?>