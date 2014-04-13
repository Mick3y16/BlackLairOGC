Example Register Form:
<form action="/user/register/" method="post" autocomplete="off">
    <label for="email">Email:</label> <span><input id="email" type="email" name="email"
                                                   placeholder="something@example.com">
        <?php if (isset($error['emailsize'])) { /* Message here... */
        }
        if (isset($error['invalidemail'])) { /* Message here... */
        }
        if (isset($error['emailexists'])) { /* Message here... */
        } ?></span><br/>
    <label for="username">Username:</label> <span><input id="username" type="text" name="user" placeholder="Username">
        <?php if (isset($error['usernamesize'])) { /* Message here... */
        }
        if (isset($error['userexists'])) { /* Message here... */
        } ?></span><br/>
    <label for="password">Password:</label> <span><input id="password" type="password" name="pwd"
                                                         placeholder="Password">
        <?php if (isset($error['passwordsize'])) { /* Message here... */
        }
        if (isset($error['unmatchingpasswords'])) { /* Message here... */
        } ?></span><br/>
    <label for="password">Password:</label> <input id="password" type="password" name="pwd2"
                                                   placeholder="Repeat Password"><br/>
    <input type="hidden" name="action" value="register">
    <input type="submit" value="Register">
</form>
<?php if (isset($failed)) { /* Message here... */
}
