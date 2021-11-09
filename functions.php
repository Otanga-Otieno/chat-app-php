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

function must_login($redirect) {

    if(!(isset($_SESSION['user']))) {
        header("Location: ".$redirect);
    }

}

function all_users() {

    global $conn;
    $all = array();
    $stmt = $conn->prepare("SELECT uemail FROM users");
    $stmt->execute();
    $stmt->bind_result($result);
    while($stmt->fetch()) {
        array_push($all, $result);
    }
    return $all;

}

function search_users($str) {

    global $conn;
    $all = array();
    $regex = "%".$str."%";
    $stmt = $conn->prepare("SELECT uemail FROM users WHERE uemail LIKE ?");
    $stmt->bind_param("s", $regex);
    $stmt->execute();
    $stmt->bind_result($result);
    while($stmt->fetch()) {
        array_push($all, $result);
    }
    return $all;

}

function insert_chat($sender, $receiver, $encryptedMessage, $key, $iv, $tag) {

    global $conn;
    $stmt = $conn->prepare("INSERT INTO chat(sender, receiver, encrypted_message, passphrase, iv, tag) VALUES(?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $sender, $receiver, $encryptedMessage, $key, $iv, $tag);
    $stmt->execute();
    $stmt->close();

}

function get_chats($user1, $user2) {

    global $conn;
    $cipher = "aes-128-gcm";

    $stmt = $conn->prepare("SELECT sender, receiver, encrypted_message, passphrase, iv, tag, timest FROM chat WHERE sender = ? AND receiver = ? OR sender = ? AND receiver = ?");
    $stmt->bind_param("ssss", $user1, $user2, $user2, $user1);
    $stmt->execute();
    $result = $stmt->get_result();
    $array = $result->fetch_all();
    
    foreach($array as $row) {
        $sender = $row[0];
        $receiver = $row[1];
        $tag = hex2bin($row[5]);
        $message = openssl_decrypt($row[2], $cipher, $row[3], $options=0, $row[4], $tag);

        if($sender == $user1) {
            echo "
                <span class='rounded p-1 m-2' style='display: inline-block; margin-left: auto !important; margin-right: 0 !important; background-color: #dcf8c6;'>".$message."</span><br>
            ";
        } else {
            echo "
                <span class='rounded p-1 m-2' style='display: inline-block; margin-right: auto !important; margin-left: 0 !important; background-color:  #fff5c4;'>".$message."</span><br>
            ";
        }
    }

}