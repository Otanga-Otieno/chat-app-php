<?php

require "functions.php";
//require "header.htm";

$id = get_latest_chat_id("alvin@otanga.co.ke", "jvn@mit");
echo nl2br("\n".gettype($id));


