<?php
namespace App\lib;


use PDO;


/**
 * Class Core
 *
 * this class creates a singleton responsible for db connection
 *
 * @author  Reham Abbady
 */
class Core {
    /**
     * @var PDO dbh
     * @var Core instance
     */
    public $dbh; // db handle
    private static $instance;
    /**
     *
     * get the database path from config.php file in the constructor
     *
     */
    private function __construct() {
        $configs = include('config.php');
        $db=($configs->dbPath);

        $this->dbh = new PDO($db);
    }
    /**
     *initiate the singleton instance
     *
     */
    public static function getInstance() {
        if (!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }


}