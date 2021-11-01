<?php

require "functions.php";

if(isset($_POST['signup'])) {

    $email = $_POST['uemail'];
    $passwordHash = password_hash($_POST['upassword'], PASSWORD_DEFAULT);

    create_user($email, $passwordHash);

}

if(isset($_POST['signin'])) {

    $email = $_POST['uemail'];
    $password = $_POST['upassword'];

    if(check_active_user($email)) {
        $passwordHash = retrievePassword($email);

        if(password_verify($password, $passwordHash)) {
            login($email);
        } else {
            echo "Incorrect password";
        }   
    } else {
        echo "User does not exist";
    }

}