<?php

require "functions.php";
require "header.htm";

$email = "alvinotanga@gmail.com";
$dcode = "nullandvoid";

send_opt_out_email($email, $dcode);