<?php

require "header.htm";
require "functions.php";

$all = all_users();

?>


<div class="container" style="text-align: center;">

    <form class="p-3" action="">
        <input class="rounded" type="text" name="search" placeholder="Search global users" oninput="searchUser(this.value)">
    </form>

    <ul id="userList" style="list-style-type: none; padding: 0;">
    <?php foreach($all as $email) { ?>
        <li><?php echo $email["uemail"]; ?></li>
    <?php } ?>
    </ul>

</div>