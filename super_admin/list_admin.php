<?php

require '../models/super_admin.php';
require 'header_super_admin.php';

$super_admin = new super_admin();


$admins_list = $super_admin->getAdmins();

echo "<br>";
print_r($admins_list);

exit();

foreach($admins_list as $admin)
{

    echo $admin["email"] . "<br>";
}
