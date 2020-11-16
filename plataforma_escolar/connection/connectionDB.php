<?php

class connectionDB
{
    /**
     * @var PDO
     */
    protected $connection;
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
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
        $datosConexion = $this->obtenerDatosConexion();

        foreach ($datosConexion as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }

        try {
            $this->connection = new PDO("mysql:host=$this->server; port=$this->port; dbname=$this->database;", $this->user, $this->password);
            //$conexion -> setAttribute(PDO::ATTR_ERRMOD, PDO::ERRMOD_EXCEPTION);
            $this->connection->exec("set character set utf8");
        } catch (Exception $th) {
            die("Error " . $th->GetMessage());
        }
    }

    private function obtenerDatosConexion() {
        $direccion = dirname(__FILE__); // Dirección este archivo
        $jsonData = file_get_contents($direccion . "/" . "config");    // Abre un archivo y devuelve su contenido

        return json_decode($jsonData, true);    // Convertimos el objeto json en un array asociativo (true)
    }

    private function convertirUTF8($array) {    // Convertir registros de la base de datos a utf-8
        array_walk_recursive($array, function(&$item, $key) {
            if(!mb_detect_encoding($item, 'utf-8')) {   // Si el item del array no esta en utf-8
                $item = utf8_encode($item); // Entonces convertierte a utf-8 este item
            }
        });
        return $array;
    }

}