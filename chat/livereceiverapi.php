<?php

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $sender = $_POST['user'];
    $receiver = $_POST['receiver'];
    $latest_id = get_latest_chat_id($sender, $receiver);

    while (true) {

        $new_id = get_latest_chat_id($sender, $receiver);

        if($new_id != $latest_id) {
            echo "works";
            break;
        }
        
    }

}
