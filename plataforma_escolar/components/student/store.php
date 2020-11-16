<?php
include_once '../../connection/connectionDB.php';

class store extends connectionDB {
    private $table = 'alumno';
    private $statement;

    public function insert($control_number, $first_name, $last_name, $email, $password) {
        $sql_query = "INSERT INTO $this->table (ncontrol, nombre, apellidos, email, pass) VALUES (:NCONTROL, :NOMBRE, :APELLIDOS, :EMAIL, :PASS)";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->bindParam(":NCONTROL", $control_number);
        $this->statement->bindParam(":NOMBRE", $first_name);
        $this->statement->bindParam(":APELLIDOS", $last_name);
        $this->statement->bindParam(":EMAIL", $email);
        $this->statement->bindParam(":PASS", $password);

        $rows = $this->statement->execute();
        if($rows == 1) {
            return $this->connection->lastInsertId();    // Retorna el id de la nueva fila
        } else {
            return 0;
        }
    }

    public function delete($control_number) {
        $sql_query = "DELETE FROM $this->table WHERE ncontrol = :NCONTROL";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->bindParam(":NCONTROL", $control_number);

        $rows = $this->statement->execute();
        if($rows >= 1) {
            return $this->statement->rowCount();   // Retornamos la cantidad de filas afectadas
        } else {
            return 0;
        }
    }

    public function update($control_number, $first_name, $last_name, $email) {
        $sql_query = "UPDATE $this->table SET nombre = :NOMBRE, apellidos = :APELLIDOS, email = :EMAIL  WHERE ncontrol = :NCONTROL";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->bindParam(":NOMBRE", $first_name);
        $this->statement->bindParam(":APELLIDOS", $last_name);
        $this->statement->bindParam(":EMAIL", $email);
        $this->statement->bindParam(":NCONTROL", $control_number);

        $rows = $this->statement->execute();
        if($rows >= 1) {
            return $this->statement->rowCount();   // Retornamos la cantidad de filas afectadas
        } else {
            return 0;
        }
    }

    public function get($control_number) {
        $sql_query = "SELECT * FROM $this->table WHERE ncontrol = :NCONTROL";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->bindParam(":NCONTROL", $control_number);
        $this->statement->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getList($start = 0, $quantity = 100) {
        $sql_query = "SELECT * FROM " . $this->table . " limit $start, $quantity";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }
}