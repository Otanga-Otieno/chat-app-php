<?php

require "../header.htm";
require "../functions.php";
must_login("../sign-in");

$receiver_username = $_GET['to'];
$receiver = retrieveEmail($receiver_username);
$sender = $_SESSION['user'];

?>

<script ></script>

<body onload="livereceiving('<?php echo $sender; ?>', '<?php echo $receiver; ?>');">
    
    <div class="container">
    
        <div class="m-5 rounded" style="border: white solid 1px;">
            <div style="background-color: #77d7c8; text-align: center; width: 100%;">
                <span><h3 style="color: white;"><?php echo $receiver_username; ?></h3></span>
            </div>
            <div class="p-2" id="chatbox" style="background-color: white; height: 70vh; width: 100%; overflow-y: scroll;">
                <?php get_chats($sender, $receiver); ?>
                <span id="lcid" hidden><?php echo get_latest_chat_id($receiver, $sender); ?></span>
            </div>
            <div style="background-color: #77d7c8; width: 100%;">
            <form class="p-1" action="">
                    <input class="rounded" id="msg" type="text" placeholder="Type a message" style="width: 85%; color: black; display: inline-block; border: none;">
                    <input id="rec" type="text" name="receiver" value="<?php echo $receiver; ?>" hidden>
                    <input id="sen" type="text" name="sender" value="<?php echo $_SESSION['user']; ?>" hidden>
                    <div style="display: inline-block; text-align: center; width: 10%;"><span name="sendMessage" onclick="sendText(); return false;" style="display: inline-block; background-color: transparent; border: none;"><i class="fas fa-paper-plane" style="display: inline; cursor: pointer;"></i></span></div>
                </form>
            </div>
        </div>
    
    </div>

</body>
