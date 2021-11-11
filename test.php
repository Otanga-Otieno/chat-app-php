<?php

require "functions.php";
require "header.htm";

$sender = "alvin@otanga.co.ke";
$receiver = "jvn@mit";

$chat = get_chat(25);
echo $chat;