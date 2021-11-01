<?php

require "config.php";

session_start();

$conn = new mysqli(Config::SERVER_NAME, Config::USER_NAME, Config::PASSWORD, Config::DB_NAME);


function create_user($email, $passwordHash, $active = 1) {

    global $conn;

    $stmt = $conn->prepare("INSERT INTO users(uemail, passwordHash, uactive) VALUES(?,?,?)");
    $stmt->bind_param("ssi", $email, $passwordHash, $active);
    $stmt->execute();
    $stmt->close();

}

function check_user($user) {

    global $conn;

    $stmt = $conn->prepare("SELECT id FROM users WHERE uemail = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    return isset($result) ? true : false;

}

function check_active($user) {

    global $conn;

    $stmt = $conn->prepare("SELECT uactive FROM users WHERE uemail = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    return $result == 1 ? true : false;

}


function check_active_user($user) {

    return check_user($user) && check_active($user) ? true : false;

}

function retrievePassword($user) {

    global $conn;
    $stmt = $conn->prepare("SELECT passwordHash FROM users WHERE uemail = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    return $result;

}

function login($user) {

    $_SESSION['user'] = $user;

}

function logout() {

    unset($_SESSION['user']);

}

function all_users() {

    global $conn;
    $stmt = $conn->prepare("SELECT uemail FROM users");
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetchAll();
    return $result;

}

function search_users($str) {

    global $conn;
    $regex = "%".$str."%";
    $stmt = $conn->prepare("SELECT uemail FROM users WHERE uemail LIKE ?");
    $stmt->bind_param("s", $regex);
    $stmt->execute();
    $result = $stmt->get_result();
    $assoc = $result->fetch_assoc();
    return $assoc;

}