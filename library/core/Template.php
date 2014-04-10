<?php

class Template
{

    protected $variables = array();
    protected $_controller;
    protected $_action;

    function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
    }

    // Set Variables
    function set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    // Display Template
    function render()
    {
        extract($this->variables);

        // Checks if a custom Header exists, else it includes the default Header...
        if (file_exists(DIR_ROOT . '/application/views/' . $this->_controller . '/header.php')) {
            include(DIR_ROOT . '/application/views/' . $this->_controller . '/header.php');
        } else {
            include(DIR_ROOT . '/application/views/header.php');
        }

        // Check if the requested View exists, else will redirect to home...
        if (file_exists(DIR_ROOT . '/application/views/' . $this->_controller . '/' . $this->_action . '.php')) {
            include(DIR_ROOT . '/application/views/' . $this->_controller . '/' . $this->_action . '.php');
        } else {
            include(DIR_ROOT . '/application/views/home/index.php');
        }

        // Checks if a custom Footer exists, else it includes the default Footer...
        if (file_exists(DIR_ROOT . '/application/views/' . $this->_controller . '/footer.php')) {
            include(DIR_ROOT . '/application/views/' . $this->_controller . '/footer.php');
        } else {
            include(DIR_ROOT . '/application/views/footer.php');
        }
    }

}
