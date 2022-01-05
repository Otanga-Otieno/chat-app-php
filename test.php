<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require "functions.php";
require "header.htm";

$name = "tydollar";
$email = retrieveEmail($name);
$email2 = "bla";

echo $email;
echo nl2br("\n");
$len = strlen($email);
echo $len;

echo $email2;
echo nl2br("\n");
$len2 = strlen($email2);
echo $len2;
