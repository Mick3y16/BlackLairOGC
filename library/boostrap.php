<?php
function autoload($className)
{
    if (file_exists(DIR_ROOT . '/library/' . strtolower($className) . '.php')) {
        require_once(DIR_ROOT . '/library/' . strtolower($className) . '.php');
    } else if (file_exists(DIR_ROOT . '/library/core/' . $className . '.php')) {
        require_once(DIR_ROOT . '/library/core/' . $className . '.php');
    } else if (file_exists(DIR_ROOT . '/application/controllers/' . $className . '.php')) {
        require_once(DIR_ROOT . '/application/controllers/' . $className . '.php');
    } else if (file_exists(DIR_ROOT . '/application/models/' . strtolower($className) . '.php')) {
        require_once(DIR_ROOT . '/application/models/' . strtolower($className) . '.php');
    } else {
        // Enable to load class...
    }
}

spl_autoload_register("autoload");

class Bootstrap
{

    public function setReporting()
    {
        if (DEVELOPMENT_ENVIRONMENT == true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
            ini_set('log_errors', 'On');
            ini_set('error_log', DIR_LOGS);
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', DIR_LOGS);
        }
    }

    public function urlProcessor()
    {
        $url = strtolower($_SERVER['REQUEST_URI']);
        $urlstring = array();
        if ($url == '/') {
            $controller = 'home';
            $action = 'index';
        } else {
            $urlstring = explode("/", substr($url, 1), 3);
            $controller = $urlstring[0];
            array_shift($urlstring);
            if (!empty($urlstring[0]) && file_exists(DIR_ROOT . '/application/controllers/' . ucfirst($controller) . 'Controller.php')) {
                if ((int)method_exists(ucfirst($controller) . 'Controller', $urlstring[0])) {
                    $action = $urlstring[0];
                    array_shift($urlstring);
                } else {
                    $action = (!empty($urlstring[1])) ? $urlstring[1] : 'index';
                    unset($urlstring[1]);
                }
            } else {
                $controller = 'home';
                $action = 'index'; // Default...
            }
        }

        $controllerName = ucfirst($controller) . 'Controller';
        $model = $controller;

        $dispatch = new $controllerName($model, $controller, $action);

        if ((int)method_exists($controllerName, $action)) {
            call_user_func_array(array($dispatch, $action), $urlstring);
        }
    }

}

//	Initiate the class
$boot = new Bootstrap();
//	Set how to log the errors
$boot->setReporting();
//	Process the http request
$boot->urlProcessor();
