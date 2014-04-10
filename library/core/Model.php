<?php

class Model extends Database
{

    protected $_model;
    //	Turn the connection public here...
    public $ogcdb;

    public function __construct()
    {
        // DB Connection must be initialized here
        $this->ogcdatabase();

        // Setting the name of the Model in use...
        $this->_model = get_class($this);
    }

    public function __destruct()
    {

    }

}
