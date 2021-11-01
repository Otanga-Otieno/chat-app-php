<?php

require "functions.php";

$name = $_POST['name'];
$data = search_users($name);

echo json_encode($data);