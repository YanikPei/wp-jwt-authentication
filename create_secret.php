<?php

require_once "./inc/class-jwt-functions.php";

$functions = new JWT_Functions();

echo $functions->create_secret();

 ?>
