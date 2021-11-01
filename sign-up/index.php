<?php

require "../header.htm";

?>


<div class="container" style="background-color: #77d7c8;">
    <form class="p-3 rounded uform" action="../forms.php" method="POST">
        <span><h3>Sign Up</h3></span>
        
        <label for="">
            <span>Email: </span><br>
            <input type="email" name="uemail">
        </label>
        <br>

        <label for="">
            <span>Password: </span><br>
            <input type="password" name="upassword">
        </label>
        <br>

        <button class="m-2 btn" type="submit" style="background-color: #77d7c8;" name="signup">Sign Up</button>
    </form>
</div>