<?php

require "header.htm";
require "functions.php";

must_login("./sign-in");
$user = $_SESSION['user'];
$all = all_users($user);

?>


<div class="container" style="text-align: center;">

    <div class="p-3">
        <a class="btn btn-danger" href="logout.php">LOG OUT</a>
        <form class="pt-3 mb-0" action="">
            <input class="rounded" style="width: 100%;" type="text" name="search" placeholder="Search global users" oninput="searchUser(this.value)" autocomplete="off">
        </form>
    
        <div class="p-2" id="userList" style="list-style-type: none; padding: 0; width: 100%;">
            <li></li><hr>
        <?php foreach($all as $email) { ?>
            <div class="card py-3 m-1" style="text-align: center; width: 100%;">
                <span style="color: black;"><b><?php echo $email; ?></b></span><br>
                <div style="width: 100%; text-align: center;"><a class="btn mainbg white" href="chat/?to=<?php echo $email; ?>">Message</a></div>
                
            </div>
        <?php } ?>
        </div>
    </div>

</div>