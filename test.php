<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require "functions.php";
require "header.htm";

$name = "tydollar";
$email = retrieveEmail($name);

echo $email;
echo nl2br("\n");
print_r($email);