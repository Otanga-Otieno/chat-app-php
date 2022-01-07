<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require "functions.php";
require "header.htm";

$bool1 = check_username("alvino10g");
$bool2 = check_username("neumann1");
$bool3 = check_username("blabla");

print_r($bool1);
echo nl2br("\n");
print_r($bool2);
echo nl2br("\n");
print_r($bool3);

echo nl2br("\n");

var_dump($bool1);
echo nl2br("\n");
var_dump($bool2);
echo nl2br("\n");
var_dump($bool3);