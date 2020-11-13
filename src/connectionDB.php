<?php

/**
 * Class conexionServer
 */
class conexionServer
{
    /**
     * @var PDO
     */
    private $conexion;
    /**
     * @var string
     */
    private $sqlquery;
    /**
     * @var PDO::statement
     */
    private $statment;
    function __construct()
    {
        /**
         * @var
         */
        try {
            $this->conexion = new PDO("mysql:host=localhost; dbname=web_api", "root", "");
            //$conexion -> setAttribute(PDO::ATTR_ERRMOD, PDO::ERRMOD_EXCEPTION);
            $this->conexion->exec("set character set utf8");
        } catch (Exception $th) {
            die("Error " . $th->GetMessage());
        }
    }
    
    /**
     * Ingresa un nuevo maestro a la base de datos.
     * @author Alfredo Lino
     * @param $nombre nombre Nombre del profesor.
     * @param $apellidos Apellidos Apellidos del profesor.
     * @param $email CorreoElectronico Correo electronico del profesor.
     * @param $celular NumeroDeCelular Celular del profesor
     * @param $password Password Contraseña encriptada del profesor
     * @return bool Devuelve si la operacion fue exitosa si o no.
     */
    public function signinProfesor($nombre, $apellidos, $email, $celular, $password){

        $this -> sqlquery = "INSERT INTO profesor(nombre, apellidos, email, celular, pass) VALUES (:NOMBRE, :APELLIDOS, :EMAIL, :CEL, :PASSW)";
        $this -> statment = $this ->conexion ->prepare($this->sqlquery);
        $this -> statment ->bindParam(":NOMBRE", $nombre, PDO::PARAM_STR);
        $this -> statment ->bindParam(":APELLIDOS", $apellidos, PDO::PARAM_STR);
        $this -> statment ->bindParam(":EMAIL", $email, PDO::PARAM_STR);
        $this -> statment ->bindParam(":CEL", $celular, PDO::PARAM_STR);
        $this -> statment ->bindParam(":PASSW", $password, PDO::PARAM_STR);
        return $this->statment->execute();
    }

    /**
     * Registra a un alumno en la base de datos del sistema
     * @param $ncontrol NumeroDeControl El numero de control (matricula) del alumno.
     * @param $nombre Nombre Nombre(s) del alumno
     * @param $apellidos Apellidos Apellidos del alumno
     * @param $email Email Correo electronico del alumno
     * @param $pass Constraseña Contraseña del alumno
     * @return boolean
     */
    public function signUpAlumno($ncontrol, $nombre, $apellidos, $email, $pass){
        $sqlquery = "INSERT INTO alumno(ncontrol, nombre, apellidos, email, pass) VALUES (:NCONTROL, :NOMBRE, :APELLIDOS, :EMAIL, :PASS)";
        $statement = $this ->conexion->prepare($sqlquery);
        $statement->bindParam(":NCONTROL", $ncontrol);
        $statement->bindParam(":NOMBRE", $nombre);
        $statement->bindParam(":APELLIDOS", $apellidos);
        $statement->bindParam(":EMAIL", $email);
        $statement->bindParam(":PASS", $pass);
        return $statement -> execute();
    }

    /**
     * Revisar la existencia del correo electronico del alumno
     * @param $email Email Correo electronico del alumno a buscar;
     * @return bool True si el registro fue encontrado, false si no fue encontrado;
     */

    public function checkExistenceAlumno($email){
        $sqlquery = "SELECT email FROM alumno WHERE email = :EMAIL";
        $statement = $this -> conexion ->prepare($sqlquery);
        $statement ->bindParam(":EMAIL", $email, PDO::PARAM_STR);
        $statement -> execute();
        $dato = $statement ->fetch(PDO::FETCH_ASSOC);
        return $dato ? true : false;
    }
}