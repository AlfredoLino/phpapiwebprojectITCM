<?php

use Firebase\JWT\JWT;

include_once "../validations/camps_validation.php";
include_once "../../plataforma_escolar/network/response.php";
include_once "../connectionDB.php";



$_POST = json_decode(file_get_contents('php://input'));
$validReq = Validations::checkCampsProfessor($_POST);

if($validReq){
}else{
    echo json_encode(response::error400());
}