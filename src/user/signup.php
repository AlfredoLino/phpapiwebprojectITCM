<?php

use Firebase\JWT\JWT;
/**
 * @author Alfredo
 *
*/
include_once "../connectionDB.php";
$dbconnection = new conexionServer();
$_POST = json_decode(file_get_contents('php://input'), true);

$invalidReq = false;

foreach($_POST as $key => $value){
    $actual = $_POST[$key];
    if(!(isset($actual) && $actual != "")){
        $invalidReq = true;
    }
}

if(!$invalidReq) {
    $dbconnection->signinProfesor($_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["celular"], $_POST["pass"]);
    if ($dbconnection) {
        $res = array("response" => true, "message" => "Usuario creado de manera satisfactoria");
        echo json_encode($res);
    } else {
        $res = array("response" => false, "message" => "Error al ingresar a la base de datos del sistema");
        echo json_encode($res);
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
