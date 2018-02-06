<html>
<?php
include 'Access.php';
echo $_COOKIE['grantaccess'];
if(accessgrant()){echo "logged in";}
?>
</HTML>