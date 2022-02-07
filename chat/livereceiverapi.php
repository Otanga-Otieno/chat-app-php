<?php

require "../functions.php";

//Check if latest chat id from user is same as latest chat id from database. Update chats accordingly

if(($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['lcid'])) {

    $sender = $_POST['user'];
    $receiver = $_POST['receiver'];
    $receiver = retrieveEmail($receiver);
    $latest_id = $_POST['lcid'];
    $new_id = get_latest_chat_id($receiver, $sender);

    if($latest_id != $new_id) {
        $message = get_chat($new_id);
        $arr = [$message, $new_id];
        echo json_encode($arr);
    } else {
        echo json_encode(["", ""]);
    }

}
