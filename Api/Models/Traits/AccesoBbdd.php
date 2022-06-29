<?php
namespace Api\Models\Traits;
use \PDO;
use \PDOException;
use \Exception;

/**
 * 
 */
trait AccesoBbdd {
    
    public function select($query = null, $params = []) {
        try {
            $stmt = $this->executeStatement($query, $params);

            // validar si se ha ejecutado el stmt
            if($stmt->rowCount() == 0) {
                throw new Exception (CODIGOS_ESTADO['404'], 404);
            }
            if(array_key_exists('id', $params)) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $result = $stmt->fetchAll();
            }
            return $result;
        } catch (PDOException $e) {
            throw new Exception ($e->getMessage(), 500);
        }

    }

    public function create($query = null, $params = []) {

        try {
            $stmt = $this->executeStatement($query, $params);

            // validar si se ha ejecutado el stmt
            if($stmt->rowCount() == 0) {
                throw new Exception (CODIGOS_ESTADO['404'], 404);
            }
            $id = $this->conn->lastInsertId();
            return $id;
        } catch (PDOException $e) {
            throw new Exception ($e->getMessage(), 500);
        }
        
    }

    public function update($query = null, $params = []) {

        try {
            $stmt = $this->executeStatement($query, $params);

            // validar si se ha ejecutado el stmt
            if($stmt->rowCount() == 0) {
                throw new Exception ('id recurso no encontrado o no se han modifcado los datos', 404);
            }
            return true;
        } catch (PDOException $e) {
            throw new Exception ($e->getMessage(), 500);
        }

        
    }

    public function delete($query = null, $params = []) {

        try {
            $stmt = $this->executeStatement($query, $params);

            // validar si se ha ejecutado el stmt
            if($stmt->rowCount() == 0) {
                throw new Exception (CODIGOS_ESTADO['404'], 404);
            }
            return true;
        } catch (PDOException $e) {
            throw new Exception ($e->getMessage(), 500);
        }
        
    }

    private function executeStatement($query, $params) {

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            throw new Exception("Unable to prepare the statement: $query", 500);
        }
        if(sizeof($params) > 0) {
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }
        }

        if(!$stmt->execute()) {
            throw new Exception("Unable to execute statement: $query");
        }
        return $stmt;
    }
}
