<?php

require "functions.php";

if(isset($_POST['signup'])) {

    $email = $_POST['uemail'];
    $username = $_POST['username'];
    if(check_username($username)) {
        header("Location: signup/");
    }
    $passwordHash = password_hash($_POST['upassword'], PASSWORD_DEFAULT);

    create_user($email, $username, $passwordHash);
    login($email);
    header("Location: ./");

}

if(isset($_POST['GsignupBtn'])) {

    $email = $_POST['g_email'];
    $username = $_POST['username'];
    if(check_username($username)) {
        header("Location: signup/");
    }

    create_google_user($email, $username);
    login($email);
    header("Location: ./");

}

if(isset($_POST['signin'])) {

    $email = $_POST['uemail'];
    $password = $_POST['upassword'];

    if(check_active_user($email)) {
        $passwordHash = retrievePassword($email);

        if(password_verify($password, $passwordHash)) {
            login($email);
            header("Location: ./");
        } else {
            echo "Incorrect password";
        }   
    } else {
        echo "User does not exist";
    }

}