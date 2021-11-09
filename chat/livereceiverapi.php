<?php

require "../functions.php";

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $sender = $_POST['user'];
    $receiver = $_POST['receiver'];
    $latest_id = get_latest_chat_id($sender, $receiver);
    $new_id = get_latest_chat_id($sender, $receiver);

    while ($latest_id == $new_id) {

        sleep(3000);
        $new_id = get_latest_chat_id($sender, $receiver);
        
    }
    
    echo get_chat($new_id);

}
