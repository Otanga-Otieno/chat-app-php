<?php

require "../header.htm";
require "../functions.php";

$to = $_GET['to'];

?>


<div class="container">
    
    <div class="m-5 rounded" style="border: white solid 1px;">
        <div style="background-color: #77d7c8; text-align: center; width: 100%;">
            <span><h3 style="color: white;"><?php echo $to; ?></h3></span>
        </div>
        <div style="background-color: white; height: 70vh; width: 100%;"></div>
        <div style="background-color: #77d7c8; width: 100%;">
            <form action="">
                <input class="rounded" type="text" placeholder="Type a message" style="width: 80%; color: black;">
                <button name="sendMessage" style="width: 20%;"><i class="fas fa-paper-plane" style="display: inline;"></i></button>
            </form>
        </div>
    </div>

</div>