<?php

require "../functions.php";

if(($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['lcid'])) {

    $sender = $_POST['user'];
    $receiver = $_POST['receiver'];
    $latest_id = $_POST['lcid'];
    $new_id = get_latest_chat_id($receiver, $sender);

    echo get_chat($new_id);

}
