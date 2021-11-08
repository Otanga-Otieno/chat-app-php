<?php

require "../functions.php";

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $message = $_POST['message'];
    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];

    $timestamp = time();
    $cipher = "aes-128-gcm";
    $key = bin2hex(openssl_random_pseudo_bytes(10));
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = bin2hex(openssl_random_pseudo_bytes($ivlen));
    $tag = bin2hex(openssl_random_pseudo_bytes(10));
    $enc = openssl_encrypt($message, $cipher, $key, $options=0, $iv, $tag);

    insert_chat($sender, $receiver, $enc, $key, $iv, $tag, $timestamp);

    echo json_encode($enc);

}