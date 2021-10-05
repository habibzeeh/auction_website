<?php

/**
 * Make connection to db the details are here to connect
 * Class db
 */
class db
{

    /**
     * @var string
     */
    public $domain;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $schema;
    /**
     * @var PDO
     */
    public $pdo;

    /**
     * db constructor.
     */
    function __construct()
    {

        $this->domain = 'localhost';
        $this->username = 'root';
        $this->password = '';
        $this->schema = 'ass1';
        $this->pdo = new PDO('mysql:dbname=' . $this->schema . ';host=' . $this->domain, $this->username, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
}
