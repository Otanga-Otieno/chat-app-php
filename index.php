<?php

require "header.htm";
require "functions.php";

$all = all_users();

?>


<div class="container" style="text-align: center;">

    <div>
        <form class="pt-3 mb-0" action="">
            <input class="rounded" style="width: 100%;" type="text" name="search" placeholder="Search global users" oninput="searchUser(this.value)" autocomplete="off">
        </form>
    
        <ul class="mt-2" id="userList" style="list-style-type: none; padding: 0; background-color: black; color: white; width: 100%;">
        <?php foreach($all as $email) { ?>
            <li><?php echo $email; ?></li><hr>
        <?php } ?>
        </ul>
    </div>

</div>