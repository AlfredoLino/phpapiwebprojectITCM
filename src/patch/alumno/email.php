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
    $email = $_POST['email'];
    try {
        $valid = JWT::decode($token, 'secretkey',array('HS256'));
        if($valid){
            $conexion ->patchEmailAlumno($_POST['alumno'], $email);
            echo json_encode(
                response::succes201("El email se ha actualizado a $email de manera exitosa")
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