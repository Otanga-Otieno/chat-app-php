<?php

require "functions.php";

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $name = $_POST['name'];
    $bool = check_username($name);
    
    if($bool) {
        echo 1;
    } else {
        echo 0;
    }

}