<?php

require "../header.htm";
require "../functions.php";

$to = $_GET['to'];

?>


<div class="container">
    
    <div class="rounded">
        <div style="background-color: #77d7c8;">
            <span><h3 style="color: white;"><?php echo $to; ?></h3></span>
        </div>
        <div style="background-color: white; height: 80%;"></div>
        <div style="background-color: #77d7c8;">
            <form action="">
                <input class="rounded" type="text" placeholder="Type a message" style="width: 100%; color: black;">
            </form>
        </div>
    </div>

</div>