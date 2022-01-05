<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

require "config.php";

session_start();

$conn = new mysqli(Config::SERVER_NAME, Config::USER_NAME, Config::PASSWORD, Config::DB_NAME);

function exchangeCode($length) {

    $bytes = random_bytes(($length)/2);
    $exchange_code = bin2hex($bytes);
    return $exchange_code;

}

function create_opt_out($email) {
    
    global $conn;
    $dcode = exchangeCode(32);

    $stmt = $conn->prepare("INSERT INTO deactivate(uemail, dcode) VALUES(?,?)");
    $stmt->bind_param("ss", $email, $dcode);
    $stmt->execute();
    $stmt->close();

    send_opt_out_email($email, $dcode);

}

function get_opt_code($email) {

    global $conn;

    $stmt = $conn->prepare("SELECT dcode FROM deactivate WHERE uemail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    return $result;

}

function send_opt_out_email($email, $dcode) {

    $url = "https://otanga.co.ke/Projects/Chat-App-PHP/";
    $link = $url."opt-out.php?user=$email&code=$dcode";
    $body = "<div style='background-color: #77d7c8;' > <div style='background-color: black; color: #77d7c8; text-align: center;'><h2>OurChat</h2></div> <div style='text-align: center; color: black; background-color: #77d7c8; padding: 5%;'><p>Thank you for choosing OurChat. </p><p>Visit <a href='$url'>OurChat</a> to talk to friends in real time. </p><br><br><span style='font-size: 0.85em;'>Didn't sign up? <a href='$link'>opt out</a> of OurChat.</span> </div> </div>";
    $altbody = "Thank you for choosing OurChat. Visit https://otanga.co.ke/Projects/Chat-App-PHP/  to talk to friends in real time. \n\nDidn't sign up? Use the link below to opt out of OurChat. \n$link";
    $subject = "WELCOME";
    send_email($email, $subject, $body, $altbody);

}

function verify_opt_out($user, $code) {

    global $conn;

    $stmt = $conn->prepare("SELECT uemail FROM deactivate WHERE dcode = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();

    if($result == $user) {
        return true;
    } else {
        return false;
    }

}

function create_user($email, $passwordHash, $active = 1) {

    global $conn;

    $stmt = $conn->prepare("INSERT INTO users(uemail, passwordHash, uactive) VALUES(?,?,?)");
    $stmt->bind_param("ssi", $email, $passwordHash, $active);
    $stmt->execute();
    $stmt->close();

    create_opt_out($email);

}

function create_google_user($email, $active = 1) {

    global $conn;

    $stmt = $conn->prepare("INSERT INTO users_google(g_email, uactive) VALUES(?,?)");
    $stmt->bind_param("si", $email, $active);
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

function check_google_user($user) {

    global $conn;

    $stmt = $conn->prepare("SELECT id FROM users_google WHERE g_email = ?");
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

function activate($user, $active = 1) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET uactive = ? WHERE uemail = ?");
    $stmt->bind_param("is", $active, $user);
    $stmt->execute();
    $stmt->close();
}


function check_active_user($user) {

    return check_user($user) && check_active($user) ? true : false;

}

function isDeactivated($user) {

    if(check_user($user)) {
        if(!check_active($user)) {
            return true;
        } 
    }
    return false;
    
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

function retrieveEmail($username) {

    global $conn;
    $stmt = $conn->prepare("SELECT uemail FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();

    if(strlen($result < 1)) {
        $stmt2 = $conn->prepare("SELECT g_email FROM users_google WHERE username = ?");
        $stmt2->bind_param("s", $username);
        $stmt2->execute();
        $stmt2->bind_result($result);
        $stmt2->fetch();
        $stmt2->close();
    }
    
    return $result;

}

function send_email($user, $subject, $body, $altbody) {

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = Config::SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = Config::SMTP_USER;
    $mail->Password   = Config::SMTP_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->setFrom('no-reply@otanga.co.ke', 'OurChat');
    $mail->addAddress($user);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->Altbody = $altbody;

    $mail->send();

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

    $stmt = $conn->prepare("SELECT username FROM users");
    $stmt->execute();
    $stmt->bind_result($result);
    while($stmt->fetch()) {
        array_push($all, $result);
    }

    $stmt2 = $conn->prepare("SELECT username FROM users_google");
    $stmt2->execute();
    $stmt2->bind_result($result2);
    while($stmt2->fetch()) {
        array_push($all, $result2);
    }

    return $all;

}

function search_users($str) {

    global $conn;
    $all = array();
    $regex = "%".$str."%";

    $stmt = $conn->prepare("SELECT username FROM users WHERE uemail LIKE ?");
    $stmt->bind_param("s", $regex);
    $stmt->execute();
    $stmt->bind_result($result);
    while($stmt->fetch()) {
        array_push($all, $result);
    }

    $stmt2 = $conn->prepare("SELECT username FROM users_google WHERE g_email LIKE ?");
    $stmt2->bind_param("s", $regex);
    $stmt2->execute();
    $stmt2->bind_result($result2);
    while($stmt2->fetch()) {
        array_push($all, $result2);
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
                <span class='rounded p-1' style='display: block; width: fit-content; margin-left: auto; margin-right: 0; background-color: #dcf8c6;'>".$message."</span><br>
            ";
        } else {
            echo "
                <span class='rounded p-1' style='display: block; width: fit-content;  margin-right: auto; margin-left: 0; background-color:  #fff5c4;'>".$message."</span><br>
            ";
        }
    }

}

function get_latest_chat_id($sender, $receiver) {

    global $conn;
    $stmt = $conn->prepare("SELECT id FROM chat WHERE sender = ? AND receiver = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("ss", $sender, $receiver);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    return $result;

}

function get_chat($id) {

    global $conn;
    $cipher = "aes-128-gcm";

    $stmt = $conn->prepare("SELECT encrypted_message, passphrase, iv, tag FROM chat WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($enc, $key, $iv, $tag);
    $stmt->fetch();

    $tag = hex2bin($tag);
    $message = openssl_decrypt($enc, $cipher, $key, $options=0, $iv, $tag);
    return $message;

}