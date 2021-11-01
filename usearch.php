<?php

require "functions.php";

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $data = search_users($name);

    echo json_encode($data);
}