<?php

session_start();

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
    require "header.htm";
    echo '
      <div class="container" style="background-color: #77d7c8;">
      <form class="p-3 rounded uform" action="forms.php" method="POST" autocomplete="off">
          <span><h3>Username</h3></span>

          <label for="">
              <span>Username: </span><br>
              <input type="text" name="username" oninput="searchUsername(this.value)"><br>
              <input type="text" name="g_email" value="'.$email.'" hidden>
              <span id="usernameWarning" style="color: red !important;" hidden>Username already exists!</span>
          </label>
          <br>

          <button class="m-2 btn" id="signupBtn" type="submit" style="background-color: #77d7c8;" name="Gsignup">Sign Up</button>
      </form>
      </div>
    ';

  }  

} else {
  header("Location: sign-in/");
}