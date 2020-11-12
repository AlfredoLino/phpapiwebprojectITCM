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
}