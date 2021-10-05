<?php

$SERVER_PATH = "http://localhost/ass1/";
session_start();

if(!strcmp($_SESSION["user"]["role"], "super_admin") ==  0)
    header ('Location: ../404.php');


?>