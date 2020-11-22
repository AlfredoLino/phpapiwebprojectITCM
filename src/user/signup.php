<?php

use Firebase\JWT\JWT;
/**
 * @author Alfredo
 *
*/
include_once "../connectionDB.php";
include_once "../validations/camps_validation.php";
include_once "../../plataforma_escolar/network/response.php";
include_once "../../vendor/autoload.php";

$conexion = new conexionServer();
$_POST = json_decode(file_get_contents('php://input'), true);

$validReq = Validations::checkCampsAlumno($_POST);

/**
 * Establecemos el arbol de decision segun el estado que arrojaron los datos
 */

if($validReq) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $data = $conexion->getAlumno($email)->fetch(PDO::FETCH_ASSOC);
    if($data){
        if($data['password'] == $pass && $data['email'] == $email){
            $token = JWT::encode(array("email"=>$email), 'secretkey');
            echo json_encode(array("status" => 200, "token"=>$token));
        }else{
            echo json_encode(response::error401());
        }
    }else{
        echo json_encode(response::error401());
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
