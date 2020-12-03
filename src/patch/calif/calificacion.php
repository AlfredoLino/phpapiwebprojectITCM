<?php 
use Firebase\JWT\JWT;
require_once "../../../vendor/autoload.php";
require_once "../../connectionDB.php";
require_once "../../validations/camps_validation.php";
include_once "../../../plataforma_escolar/network/response.php";

$_POST = json_decode(file_get_contents('php://input'), true);
$token = getallheaders()['Authorization'];
$conexion = new conexionServer();
$df = $conexion->getSignatures();

try {
    $datos = array("data"=>[]);
    while ($data = $df->fetch(PDO::FETCH_ASSOC)) {
        $datos["data"][] = $data;
    }
} catch (Exception $th) {
    echo "error xd";
}

echo json_encode($datos);