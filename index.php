<?php

require "header.htm";
require "functions.php";

$all = all_users();

?>


<div class="container" style="text-align: center;">

    <form class="pt-3 mb-0" action="">
        <input class="rounded" type="text" name="search" placeholder="Search global users" oninput="searchUser(this.value)" autocomplete="off">
    </form>

    <ul class="mt-0" id="userList" style="list-style-type: none; padding: 0; background-color: black; color: white;">
    <?php foreach($all as $email) { ?>
        <li><?php echo $email; ?></li><hr>
    <?php } ?>
    </ul>

</div>