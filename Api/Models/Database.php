<?php

namespace Api\Models;

use \PDO;
use \PDOException;
use \Exception;
require_once(PROJECT_ROOT_PATH."\Api\Models\Traits\AccesoBbdd.php");
require_once(PROJECT_ROOT_PATH."\Api\Utils\config.php");
use Api\Models\Traits\AccesoBbdd;

class Database {
    protected $conn = null;
    use AccesoBbdd;

    public function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";";
        try {
            $this->conn = new PDO($dsn,  DB_USER, DB_PWD);
            // Forma de conexion a la DB y recoger datos por defecto, en este caso associative array
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL);
            $this->conn->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, true);
        } catch (PDOException $e) {
            throw new Exception((string)$e->getMessage(), (int)$e->getCode());
        }
        catch (Exception $e){
                throw new Exception((string)$e->getMessage(), (int)$e->getCode());
        }
    }

    
}