<?php

require "functions.php";

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $data = search_users();
    echo json_encode($data);

    /*if($name == "") {
        $data = all_users();
        echo json_encode($data);
    } else {
        $data = search_users($name);
        echo json_encode(array_values($data));
    }*/    
}