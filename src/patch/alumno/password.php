<?php 

use Firebase\JWT\JWT;
require_once "../../../vendor/autoload.php";
require_once "../../connectionDB.php";
require_once "../../validations/camps_validation.php";
include_once "../../../plataforma_escolar/network/response.php";

$_POST = json_decode(file_get_contents('php://input'), true);
$token = getallheaders()['Authorization'];
$conexion = new conexionServer();

if(Validations::checkEmailPatch($_POST)){
    $password = $_POST['password'];
    try {
        $valid = JWT::decode($token, 'secretkey',array('HS256'));
        if($valid){
            $conexion ->patchEmailAlumno($_POST['alumno'], $password);
            echo json_encode(
                response::succes201("El pasword se ha actualizado a $password de manera exitosa")
            );
        }else{
            echo json_encode(response::error401());
        }
    } catch (Exception $JWTException) {
        echo json_encode(response::error401());
    }

}else{
    echo json_encode(response::error401());
}