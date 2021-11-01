<?php

require "config.php";

session_start();

$conn = new mysqli(Config::SERVER_NAME, Config::USER_NAME, Config::PASSWORD, Config::DB_NAME);
