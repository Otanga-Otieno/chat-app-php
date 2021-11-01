<?php

if(isset('signup')) {

    $email = $_POST['uemail'];
    $passwordHash = password_hash($_POST['upassword']);

    echo $email." and ".$passwordHash;

}

if(isset('signin')) {

    $email = $_POST['uemail'];
    $passwordHash = password_hash($_POST['upassword']);

    echo $email." and ".$passwordHash;

}