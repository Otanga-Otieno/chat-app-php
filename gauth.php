<?php

require "functions.php";

if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  if(isset($token['access_token'])) {
    $client->setAccessToken($token['access_token']);
  } else {
    header("Location: ".$_SERVER['PHP_SELF']);
  }
   
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;

  if(check_user($email)) {
    if(check_active($email)) {
      login($email);
      header("Location: ./");
    } else {
      reactivate($email);
      login($email);
      header("Location: ./");
    }
  } else {
    create_user($email);
    header("Location: ./");
  }

  echo nl2br($email."\n".$name);
  
}