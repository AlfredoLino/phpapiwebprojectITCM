<?php

use Firebase\JWT\JWT;
/**
 * @author Alfredo
 *
*/
include_once "../connectionDB.php";
$dbconnection = new conexionServer();
$_POST = json_decode(file_get_contents('php://input'), true);
$dbconnection->signinProfesor($_POST["nombre"], $_POST["apellidos"],$_POST["email"], $_POST["celular"],$_POST["pass"]);
if($dbconnection){
    $res = array("response" => $dbconnection);
    echo json_encode($res);
}else{
    $res = array("response" => false);
    echo json_encode($res);
}
/*$conexion = new conexionServer();

$datares = $conexion ->getProfesor();
/*
while($record = $datares->fetch(PDO::FETCH_ASSOC)){

    echo var_dump($record);
}
*/
