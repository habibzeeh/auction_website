<?php
 $pagename ='logout.php';
 $loginout = 'logout';

require 'header.php';

if($loginout = 'logout'){
  session_start();
session_destroy();
echo $mesage = 'You are now logged out';
header("location:index.php");  
}


?>
