<?php
$server = 'localhost';
$username = 'root';
$password = '';
//The name of the schema we created earlier in MySQL workbench
//If this schema does not exist you will get an error!
$schema = 'ass1';
$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
[ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


?>
