<?php

require "functions.php";
//require "header.htm";

$sender = "alvin@otanga.co.ke";
$receiver = "jvn@mit";
$id = get_latest_chat_id($sender, $receiver);
echo $id;


