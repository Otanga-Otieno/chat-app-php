<?php

require "../header.htm";

?>


<div class="container">
    <form class="p-3 rounded uform" action="../forms.php" method="POST">
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

        <button class="m-2 btn" type="submit" style="background-color: #77d7c8;" name="signin">Sign In</button>

        <a class="btn btn-outline-dark" href="'.$client->createAuthUrl().'" role="button" style="text-transform:none">
            <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />Login with Google
        </a>
    </form>
</div>