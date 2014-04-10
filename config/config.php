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

// Directories
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DIR_LOGS', DIR_ROOT . '/tmp/logs/error.log');

// Magic in the making
require_once(DIR_ROOT . '/library/bootstrap.php');
