Example Login Form:
<form action="/user/login/" method="post" autocomplete="off">
    <label for="email">Email:</label> <input id="email" type="email" name="email" placeholder="something@example.com" >
    <label for="password">Password:</label> <input id="password" type="password" name="pwd" placeholder="Password" >
    <input type="checkbox" name="remember" value="1"> Remember Me!
    <input type="hidden" name="action" value="login">
    <input type="submit" value="Login">
</form>
<?php if(isset($error['accnotfound'])) { /* Message here... */ } ?>
<?php if(isset($failed)) { /* Message here... */ } ?>
<?php if(isset($success)) { /* Message here... */ } ?>