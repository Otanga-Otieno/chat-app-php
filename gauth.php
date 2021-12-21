<?php

require "functions.php";
require "vendor/autoload.php";

$client = new Google_Client();
$client->setClientId(GClient::CLIENT_ID);
$client->setClientSecret(GClient::CLIENT_SECRET);
$client->addScope("email");
$client->addScope("profile");
$redirectUri = 'https://otanga.co.ke/Projects/Chat-App-PHP/gauth.php';
$client->setRedirectUri($redirectUri);

if (isset($_GET['code'])) {

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if(isset($token['access_token'])) {
      $client->setAccessToken($token['access_token']);
    } else {
      header("Location: sign-in/");
    }
   
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    $name =  $google_account_info->name;
  
    if(check_google_user($email)) {
      login($email);
      header("Location: ./");
    } else {
      create_google_user($email);
      login($email);
      header("Location: ./");
    }
  
} else {
    header("Location: sign-in/");
}