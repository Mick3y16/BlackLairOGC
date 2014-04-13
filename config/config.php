<?php

// Website Information
define('WEBSITE_DOMAIN', 'http://www.example.com/');
define('WEBSITE_TITLE', 'Website Title');
define('WEBSITE_SHORTTITLE', 'Website Short Title');
define('WEBSITE_DESCRIPTION', 'Website Description');
define('WEBSITE_KEYWORDS', 'Website Keywords');
define('WEBSITE_EMAIL', 'email@example.com');

// Working Environment
define('DEVELOPMENT_ENVIRONMENT', true);

// Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_name');
define('DB_USER', 'db_user');
define('DB_PASS', 'db_password');

// Cookie
define('COOKIE_NAME', 'PHPSESSID');
define('COOKIE_EXPIRE', '0'); // Until the browser is closed
define('COOKIE_MINEXPIRE', time() + 86400); // 24 hours duration
define('COOKIE_MAXEXPIRE', time() + 2592000); // 30 days duration
define('COOKIE_PATH', '/');
define('COOKIE_DOMAIN', '.example.com');
define('COOKIE_SECUREONLY', false);
define('COOKIE_HTTPONLY', true);

/* Don't change anything below this point... */

// Directories
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DIR_LOGS', DIR_ROOT . '/tmp/logs/error.log');
define('DIR_SESS', DIR_ROOT . '/tmp/session/');

// php.ini Settings
ini_set('session.gc_probability', '1');
ini_set('session.gc_divisor', '10'); // Every 10 requests the server will attempt a cleanup on old session files...
ini_set('session.hash_function', 'sha512');

// Session
session_save_path(DIR_SESS); // Sets the current session save path
session_name(COOKIE_NAME); // Sets the current session name
session_set_cookie_params(COOKIE_EXPIRE, COOKIE_PATH, COOKIE_DOMAIN, COOKIE_SECUREONLY, COOKIE_HTTPONLY); // Sets the parameters of the Cookie
session_start();

// Magic in the making
require_once(DIR_ROOT . '/library/bootstrap.php');
