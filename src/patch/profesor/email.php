<?php 

use Firebase\JWT\JWT;
require_once "../../../vendor/autoload.php";
require_once "../../connectionDB.php";
require_once "../../validations/camps_validation.php";
include_once "../../../plataforma_escolar/network/response.php";

$_POST = json_decode(file_get_contents('php://input'), true);
$token = getallheaders()['Authorization'];
$conexion = new conexionServer();

if (Validations::checkEmailPatch($_POST)) {
    try {
        $valid = JWT::decode($token, 'secretkey', array('HS256'));
        if ($valid) {
            $conexion->patchEmailAlumno();
        } else {
            echo json_encode(response::error401());
        }
        
    } catch (Exception $error) {
        echo json_encode($error);
    }
} else {
    # code...
}





