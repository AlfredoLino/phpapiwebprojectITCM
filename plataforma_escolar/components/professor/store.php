<?php
include_once '../../connection/connectionDB.php';

class store extends connectionDB {
    private $table = 'profesor';
    private $statement;

    public function insert($record_number, $first_name, $last_name, $email, $cellphone, $password) {
        $sql_query = "INSERT INTO $this->table (_id, nombre, apellidos, email, celular, pass) VALUES (:RECORDNUMBER, :NOMBRE, :APELLIDOS, :EMAIL, :CELULAR, :PASS)";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->bindParam(":RECORDNUMBER", $record_number);
        $this->statement->bindParam(":NOMBRE", $first_name);
        $this->statement->bindParam(":APELLIDOS", $last_name);
        $this->statement->bindParam(":EMAIL", $email);
        $this->statement->bindParam(":CELULAR", $cellphone);
        $this->statement->bindParam(":PASS", $password);

        $rows = $this->statement->execute();
        if($rows == 1) {
            return $this->connection->lastInsertId();    // Retorna el id de la nueva fila
        } else {
            return 0;
        }
    }

    public function delete($record_number) {
        $sql_query = "DELETE FROM $this->table WHERE _id = :RECORDNUMBER";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->bindParam(":RECORDNUMBER", $record_number);

        $rows = $this->statement->execute();
        if($rows >= 1) {
            return $this->statement->rowCount();   // Retornamos la cantidad de filas afectadas
        } else {
            return 0;
        }
    }

    public function update($record_number, $first_name, $last_name, $email, $cellphone) {
        $sql_query = "UPDATE $this->table SET nombre = :NOMBRE, apellidos = :APELLIDOS, email = :EMAIL, celular = :CELULAR  WHERE _id = :RECORDNUMBER";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->bindParam(":NOMBRE", $first_name);
        $this->statement->bindParam(":APELLIDOS", $last_name);
        $this->statement->bindParam(":EMAIL", $email);
        $this->statement->bindParam(":CELULAR", $cellphone);
        $this->statement->bindParam(":RECORDNUMBER", $record_number);

        $rows = $this->statement->execute();
        if($rows >= 1) {
            return $this->statement->rowCount();   // Retornamos la cantidad de filas afectadas
        } else {
            return 0;
        }
    }

    public function get($record_number) {
        $sql_query = "SELECT * FROM $this->table WHERE _id = :RECORDNUMBER";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->bindParam(":RECORDNUMBER", $record_number);
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
