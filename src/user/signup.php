<?php

use Firebase\JWT\JWT;
/**
 * @author Alfredo
 *
*/
include_once "../connectionDB.php";
$dbconnection = new conexionServer();
$_POST = json_decode(file_get_contents('php://input'), true);

/**
 * Definimos los campos que necesitamos en un array para verificar si existen en la variable global $_POST
 */

$defined_keys = array("ncontrol","nombre", "apellidos", "email", "pass");

/**
 * Variable booleana para revisar si los datos son validos.
 */

$validReq = true;

/**
 * Iteramos sobre la variavle "definded_keys" para ver si uno falta o está en mal forma.
 */
foreach($defined_keys as $key){
    if(!isset($_POST[$key]) || $_POST[$key] == ""){
        $validReq = false;
    }
}
/**
 * Establecemos el arbol de decision segun el estado que arrojaron los datos
 */
if($validReq) {
    /**
     * Comprobamos si el correo no esxite ya en la base de datos
     */
    if($dbconnection->checkExistenceAlumno($_POST["email"])){
        echo json_encode(array("reponse" => false, "message" => "El email ya existe en la base de datos"));
    }else{
        /**
         * Usamos la funcion signUpAlumno de nuestra clase consexionServer para insertar los datos en la BDD
         */
        $dbconnection ->signUpAlumno($_POST["ncontrol"], $_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["pass"]);
        /**
         * Dependiendo la variabble enviamos la respuesta pertinente
         */
        if ($dbconnection) {
            $res = array("response" => true, "message" => "Usuario creado de manera satisfactoria");
            echo json_encode($res);
        } else {
            $res = array("response" => false, "message" => "Error al ingresar a la base de datos del sistema");
            echo json_encode($res);
        }
    }
}else{
    echo json_encode(array("response" => false, "message" => "Datos invalidos. Por favor, corrija."));
}
/*$conexion = new conexionServer();

$datares = $conexion ->getProfesor();
/*
while($record = $datares->fetch(PDO::FETCH_ASSOC)){

    echo var_dump($record);
}
*/
