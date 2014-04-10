<?php

class UserController extends Controller
{

    public function login()
    {

    }

    public function register()
    {
        if ((!empty($_POST['action'])) && $_POST['action'] == 'register') {
            // Assign the variables from POST to regular ones..
            $email = $_POST['email'];
            $username = $_POST['user'];
            $password = $_POST['pwd'];

            /* Validation Below... */

            // Sanitizing the Variables
            // Strip characters that have a numerical value < 32 http://en.wikipedia.org/wiki/ASCII#ASCII_printable_characters
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            $password = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

            // Validate Email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                exit(); /* Error... */
            }

            // Check string length, no less than 3 characters and no more than 32 characters...
            if (strlen($email) < 3 || strlen($email) > 255) { /* Error... */
            }
            if (strlen($username) < 3 || strlen($username) > 32) { /* Error... */
            }
            if (strlen($password) < 3 || strlen($password) > 16) { /* Error... */
            }

            // Escape strings ( ' " / )...
            $email = addslashes($email);
            $username = addslashes($username);

            // Hash the password...
            $password = crypt($password, '$2a$07$LLSqwMGoErQqrJKweFGHd$');

            // Start storing the results in the DataBase...
            $this->user->ogcdb->query("INSERT INTO `ogc_users` (email, password, username) VALUES ('" . $email . "','" . $password . "','" . $username . "')");

        } else {
            // If the user tried to access the page directly, redirect him to the home page...
            header("Location: " . WEBSITE_DOMAIN);
        }

    }

}
