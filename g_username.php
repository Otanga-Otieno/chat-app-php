<?php

require "header.htm";

?>

<div class="container" style="background-color: #77d7c8;">
    <form class="p-3 rounded uform" action="../forms.php" method="POST" autocomplete="off">
        <span><h3>Username</h3></span>

        <label for="">
            <span>Username: </span><br>
            <input type="text" name="username" oninput="searchUsername(this.value)"><br>
            <span id="usernameWarning" style="color: red !important;" hidden>Username already exists!</span>
        </label>
        <br>

        <button class="m-2 btn" id="GsignupBtn" type="submit" style="background-color: #77d7c8;" name="signup">Sign Up</button>
    </form>
</div>