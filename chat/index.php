<?php

require "../header.htm";
require "../functions.php";
must_login("../sign-in");

$receiver = $_GET['to'];
$sender = $_SESSION['user'];

?>

<script>livereceiver("<?php echo $sender; ?>", "<?php echo $receiver; ?>");</script>

<div class="container">
    
    <div class="m-5 rounded" style="border: white solid 1px;">
        <div style="background-color: #77d7c8; text-align: center; width: 100%;">
            <span><h3 style="color: white;"><?php echo $receiver; ?></h3></span>
        </div>
        <div class="p-2" id="chatbox" style="background-color: white; height: 70vh; width: 100%; overflow-y: scroll;">
            <?php get_chats($sender, $receiver); ?>
        </div>
        <div style="background-color: #77d7c8; width: 100%;">
            <form action="">
                <input class="rounded" id="msg" type="text" placeholder="Type a message" style="width: 75%; color: black; display: inline-block;">
                <input id="rec" type="text" name="receiver" value="<?php echo $receiver; ?>" hidden>
                <input id="sen" type="text" name="sender" value="<?php echo $_SESSION['user']; ?>" hidden>
                <span name="sendMessage" onclick="sendText(); return false;" style="width: 20%; display: inline-block; background-color: transparent; border: none;"><i class="fas fa-paper-plane" style="display: inline;"></i></span>
            </form>
        </div>
    </div>

</div>