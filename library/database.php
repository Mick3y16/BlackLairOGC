<?php

class Database
{

    private $host = DB_HOST;
    private $ogcdbname = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $error;
    protected $ogcdb;

    public function ogcdatabase()
    {
        // Set Database
        $ogc = 'mysql:host=' . $this->host . ';dbname=' . $this->ogcdbname . ';charset=utf8';
        // Set options if needed
        $options = array();
        // Create DB connection
        try {
            $this->ogcdb = new PDO($ogc, $this->user, $this->pass, $options);
        } // Catch any errors
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function ogcdatabaseinfo()
    {
        return array(
            'server' => $this->ogcdb->getAttribute(PDO::ATTR_SERVER_INFO),
            'client' => $this->ogcdb->getAttribute(PDO::ATTR_CLIENT_VERSION),
            'driver' => $this->ogcdb->getAttribute(PDO::ATTR_DRIVER_NAME),
            'version' => $this->ogcdb->getAttribute(PDO::ATTR_SERVER_VERSION),
            'connection' => $this->ogcdb->getAttribute(PDO::ATTR_CONNECTION_STATUS)
        );
    }

}
