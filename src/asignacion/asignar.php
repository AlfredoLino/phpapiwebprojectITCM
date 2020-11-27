<?php
    //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjEyMzU0NmEi.HuD3dqQrF2awhUYG2zZsUPh289Vjsdq-isb-GrEsWdc 
    use Firebase\JWT\JWT;
    require_once "../../vendor/autoload.php";
    require_once "../validations/camps_validation.php";
    include_once "../../plataforma_escolar/network/response.php";
    $_POST = json_decode(file_get_contents('php://input'), true);

    $token = getallheaders()['Authorization'];
    $validReq = Validations::checkAsignacion($_POST);
    $conexion = new conexionServer();

    if($validReq){
        if(JWT::decode($token, 'secret')){
            $conexion ->insertAsignacion($_POST['alumno'], $_POST['grupo']);
        }else{
            echo json_encode(response::error401());
        }
    }else{
        echo json_encode(response::error401());
    }
?>