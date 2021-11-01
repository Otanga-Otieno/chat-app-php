<?php

require "functions.php";

if(isset($_POST['signup'])) {

    $email = $_POST['uemail'];
    $passwordHash = password_hash($_POST['upassword'], PASSWORD_DEFAULT);

    echo $email." and ".$passwordHash;

}

if(isset($_POST['signin'])) {

    $email = $_POST['uemail'];
    $passwordHash = password_hash($_POST['upassword'], PASSWORD_DEFAULT);

    echo $email." and ".$passwordHash;

}