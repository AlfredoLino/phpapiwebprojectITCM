<?php
include_once '../../connection/connectionDB.php';

class store extends connectionDB {
    private $table = 'grupo';
    private $statement;

    public function insert($id, $subject, $schedule, $professor) {
        $sql_query = "INSERT INTO $this->table (_id, materia, horario, profesor) VALUES (:ID, :MATERIA, :HORARIO, :PROFESOR)";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->bindParam(":ID", $id);
        $this->statement->bindParam(":MATERIA", $subject);
        $this->statement->bindParam(":HORARIO", $schedule);
        $this->statement->bindParam(":PROFESOR", $professor);

        $rows = $this->statement->execute();
        if($rows == 1) {
            return $this->connection->lastInsertId();    // Retorna el id de la nueva fila
        } else {
            return 0;
        }
    }

    public function delete($id) {
        $sql_query = "DELETE FROM $this->table WHERE _id = :ID";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->bindParam(":ID", $id);

        $rows = $this->statement->execute();
        if($rows >= 1) {
            return $this->statement->rowCount();   // Retornamos la cantidad de filas afectadas
        } else {
            return 0;
        }
    }

    public function update($id, $subject, $schedule, $professor) {
        $sql_query = "UPDATE $this->table SET materia = :MATERIA, horario = :HORARIO, profesor = :PROFESOR  WHERE _id = :ID";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->bindParam(":MATERIA", $subject);
        $this->statement->bindParam(":HORARIO", $schedule);
        $this->statement->bindParam(":PROFESOR", $professor);
        $this->statement->bindParam(":ID", $id);

        $rows = $this->statement->execute();
        if($rows >= 1) {
            return $this->statement->rowCount();   // Retornamos la cantidad de filas afectadas
        } else {
            return 0;
        }
    }

    public function get($id) {
        $sql_query = "SELECT * FROM $this->table WHERE _id = :ID";
        $this->statement = $this->connection->prepare($sql_query);
        $this->statement->bindParam(":ID", $id);
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

