<?php

require "../header.htm";

?>


<div class="container">
    <form class="p-3" action="../forms.php" method="POST" style="text-align: center;">
        <span><h3>Sign In</h3></span>
        
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

        <button class="p-2" type="submit" name="signin">Sign In</button>
    </form>
</div>