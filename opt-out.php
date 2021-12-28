<?php

require "functions.php";

$user = $_GET['user'];
$code = $_GET['code'];
$bool = verify_opt_out($user, $code);

if ($bool) {

    activate($user, 0);
    echo "Your account has been deactivated successfully.";
    
} else {

    echo "Invalid deactivation code";

}