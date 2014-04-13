<?php

class UserController extends Controller
{

    public function activate($urlstring)
    {
        // Blow up the string to get both the user and the activation code into separate variables...
        $urlstring = explode("=", $urlstring);
        // Count the results to see if the string is valid...
        if (count($urlstring) == 2 && $urlstring[1] != 0) {
            $username = filter_var($urlstring[0], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            $activation = filter_var($urlstring[1], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            if ($this->user->activateaccount($username, $activation)) {
                // Account activated successfully
                $success = true;
                $this->set('success', $success);
            } else {
                // Problem activating the account...
                $failed = true;
                $this->set('failed', $failed);
            }
        } else {
            $error['invalidstring'] = true;
            $this->set('error', $error);
        }
    }

    public function login()
    {
        if ((!empty($_POST['action'])) && $_POST['action'] == 'login') {
            unset($_POST['action']);
            // Assign the variables from POST...
            $email = $_POST['email'];
            $password = $_POST['pwd'];

            // Create the storage for errors...
            $error = array();

            // Sanitizing the Variables http://en.wikipedia.org/wiki/ASCII#ASCII_printable_characters
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $password = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

            // Hash the password with blowfish...
            $password = crypt($password, '$2a$07$LLSqwMGoErQqrJKweFGHd$');

            // Check if the user exists in the database...
            if ($this->user->loginuser($email, $password) != 1) {
                $error['accnotfound'] = true;
            }

            // Check if there were errors
            if (!empty($error)) {
                // Return the errors to the user...
                $this->set('error', $error);
            } else {
                if ($this->user->checkactivation($email, $password) == 1) {
                    // Account is active...
                    // Check is the RememberMeCheckBox was checked...
                    if (isset($_POST['remember'])) {
                        $rememberme = true;
                    } else {
                        $rememberme = false;
                    }
                    // Assign cookie duration accordingly, 30 days or 24hours...
                    define('COOKIE_ID', session_id());
                    if ($rememberme) {
                        setcookie(COOKIE_NAME, COOKIE_ID, COOKIE_MAXEXPIRE, COOKIE_PATH, COOKIE_DOMAIN, COOKIE_SECUREONLY, COOKIE_HTTPONLY);
                    } else {
                        setcookie(COOKIE_NAME, COOKIE_ID, COOKIE_MINEXPIRE, COOKIE_PATH, COOKIE_DOMAIN, COOKIE_SECUREONLY, COOKIE_HTTPONLY);
                    }
                    // Regenerate the id...
                    session_regenerate_id();
                    // Store the needed variables in the Cookie...
                    $_SESSION['authenticated'] = true;
                    $_SESSION['username'] = $this->user->getuser($email);
                    $_SESSION['userip'] = $_SERVER['REMOTE_ADDR']; // User's IP Address
                    $_SESSION['browser'] = $_SERVER['HTTP_USER_AGENT']; // User's Browser
                    // Login worked, redirecting the user in 5 seconds...
                    $success = true;
                    $this->set('success', $success);
                    header('refresh:5;url=' . WEBSITE_DOMAIN);
                } else {
                    // Account is inactive...
                    $failed = true;
                    $this->set('failed', $failed);
                }
            }
        }
    }

    public function logout()
    {
        if ((!empty($_POST['action'])) && $_POST['action'] == 'logout') {
            // Unset all the variables inside $_SESSION...
            $_SESSION = array();
            // Delete the Cookie
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 2592000);
            }
            // Finally destroy the session...
            session_regenerate_id(true);
            session_destroy();
            // Logout worked, redirecting the user in 5 seconds...
            $success = true;
            $this->set('success', $success);
            header('refresh:5;url=' . WEBSITE_DOMAIN);
        }
    }

    public function register()
    {
        if ((!empty($_POST['action'])) && $_POST['action'] == 'register') {
            unset($_POST['action']);
            // Assign the variables from POST...
            $email = $_POST['email'];
            $username = $_POST['user'];
            $password = $_POST['pwd'];
            $password2 = $_POST['pwd2'];


            /* Validation Below... */
            // Sanitizing the Variables http://en.wikipedia.org/wiki/ASCII#ASCII_printable_characters
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            $password = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            $password2 = filter_var($password2, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

            // Create the storage for errors...
            $error = array();

            // Validate Email...
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['invalidemail'] = true;
            }

            // Check string length, no less than 6/3 characters and no more than 64/32 characters...
            if (strlen($email) < 6 || strlen($email) > 64) {
                $error['emailsize'] = true;
            }
            if (strlen($username) < 3 || strlen($username) > 32) {
                $error['usernamesize'] = true;
            }
            if (strlen($password) < 3 || strlen($password) > 32) {
                $error['passwordsize'] = true;
            }

            // Compare both password fields...
            if ($password != $password2) {
                $error['unmatchingpasswords'] = true;
            }

            // Check if the email or username already exist in the DB...
            if ($this->user->checkemailexists($email) == 1) {
                $error['emailexists'] = true;
            }
            if ($this->user->checkuserexists($username) == 1) {
                $error['userexists'] = true;
            }

            /* Missing CAPTCHA Validation */

            // Now the script checks if there were errors during the validations else it stores the values in the DB...
            if (!empty($error)) {
                // Return the errors to the user...
                $this->set('error', $error);
            } else {
                // Generate the activation code...
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $randomstring = '';
                for ($i = 0; $i < 15; $i++) {
                    $randomstring .= $characters[rand(0, strlen($characters) - 1)];
                }
                $activation = $username . '=' . $randomstring;

                // Prepare the email to send the user
                $to = $email;
                $subject = WEBSITE_SHORTTITLE . ' - Account Activation';
                $message = '
					<html>
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>' . WEBSITE_SHORTTITLE . ' - Account Activation</title>
					</head>
					<body>
						<p>Dear ' . $username . ',</p>
						<p>Thank you for registering in ' . WEBSITE_TITLE . '.<br/>Your login info is shown below, please keep it to yourself.</p>
						<p><strong>Email:</strong> ' . $email . '<br/><strong>Password:</strong> ' . $password . '</p>
						<p>Before being able to login and create your profile, we must first ask that you activate your account.<br/>To do so, please follow the link below:<p>
						<a href="' . WEBSITE_DOMAIN . 'user/activate/' . $activation . '">' . WEBSITE_DOMAIN . 'user/activate/' . $activation . '</a>
						<p>If you encounter any problems or have any questions we may help with, please send an email to: <a href="mailto:' . WEBSITE_EMAIL . '">' . WEBSITE_EMAIL . '</a></p>
						<p>Best Regards,<br/>' . WEBSITE_SHORTTITLE . ' Team.</p>
					</body>
					</html>';
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers .= 'From: ' . WEBSITE_SHORTTITLE . ' Team <' . WEBSITE_EMAIL . '>' . "\r\n";

                // Hash the password...
                $password = crypt($password, '$2a$07$LLSqwMGoErQqrJKweFGHd$');

                // Start storing the results in the DataBase...
                if ($this->user->registeruser($email, $password, $username, $randomstring)) {
                    // Mail the account info...
                    mail($to, $subject, $message, $headers);

                    // Account Created Successfully!
                    $success = true;
                    $this->set('success', $success);
                } else {
                    // Problem saving the account to the database...
                    $failed = true;
                    $this->set('failed', $failed);
                }
            }
        }
    }

}
