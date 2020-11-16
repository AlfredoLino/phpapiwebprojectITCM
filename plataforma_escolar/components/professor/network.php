<?php
require_once '../../network/response.php';
require_once 'controller.php';

$response = new response();
$controller = new controller();

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['page_number']) && isset($_GET['quantity'])) {   /* http://localhost/plataforma_escolar/components/professor/network.php?page_number=1&quantity=100 */
        $page = $_GET['page_number'];
        $quantity = $_GET['quantity'];
        $listStudents = $controller->listProfessors($page, $quantity);
        header('Content-Type: application/json');
        echo json_encode($listStudents);
        http_response_code(200);
    } else if(isset($_GET['id'])) {     /* http://localhost/plataforma_escolar/components/professor/network.php?id=12345      id = _id */
        $record_number = $_GET['id'];
        $dataStudent = $controller->getProfessor($record_number);
        header('Content-Type: application/json');
        echo json_encode($dataStudent);
        http_response_code(200);
    }

} else if($_SERVER['REQUEST_METHOD'] == 'POST') {   /* http://localhost/plataforma_escolar/components/professor/network.php */
    /* enviar json ej.
    {
	"record_number" : "56784",
    "first_name" : "Carlos",
    "last_name" : "Hernandez",
    "email" : "carlos@gmail.com",
    "cellphone" : "8334023142",
    "password" : "123456",
    "token" : "rgbkrgewlhgelwa"
    } */
    // Recibir datos
    $postBody = file_get_contents('php://input');
    // Enviar los datos al controlador
    $dataArray = $controller->addProfessor($postBody);

    // Devolver respuesta
    header('Content-Type: application/json');
    if(isset($dataArray['result']['error_id'])) {  // Si el arreglo result contiene una fila con error_id(la cual se agrega en caso de llamada a un error)
        $response_code = $dataArray['result']['error_id'];
        http_response_code($response_code);
    } else {
        http_response_code(200);
    }
    echo json_encode($dataArray);  // Retorna en formato json el arreglo de la respuesta (como cadena)

} else if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    /*  enviar json ej.
     * {
	"record_number" : "56784",
    "first_name" : "Roberto",
    "last_name" : "Hernandez",
    "email" : "roberto@gmail.com",
    "cellphone" : "8334023142",
    "token" : "rgbkrgewlhgelwa"
    }
     *
     */
    // Recibir datos
    $postBody = file_get_contents('php://input');

    // Enviar los datos al controlador
    $dataArray = $controller->updateProfessor($postBody);

    // Devolver respuesta
    header('Content-Type: application/json');
    if(isset($dataArray['result']['error_id'])) {  // Si el arreglo result contiene una fila con error_id(la cual se agrega en caso de llamada a un error)
        $response_code = $dataArray['result']['error_id'];
        http_response_code($response_code);
    } else {
        http_response_code(200);
    }
    echo json_encode($dataArray);  // Retorna en formato json el arreglo de la respuesta (como cadena)

} else if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    /* enviar json ej.
     * {
	    "record_number" : "56784",
        "token" : "rgbkrgewlhgelwa"
        }
     */
    $headers = getallheaders();
    if(isset($headers["token"]) && isset($headers["id"])){
        //recibimos los datos enviados por el header
        $send = array(
            "token" => $headers["token"],
            "id" =>$headers["id"]
        );
        $postBody = json_encode($send);
    } else {
        // Recibir datos por el body
        $postBody = file_get_contents('php://input');
    }

    // Enviar los datos al controlador
    $dataArray = $controller->removeProfessor($postBody);

    // Devolver respuesta
    header('Content-Type: application/json');
    if(isset($dataArray['result']['error_id'])) {  // Si el arreglo result contiene una fila con error_id(la cual se agrega en caso de llamada a un error)
        $response_code = $dataArray['result']['error_id'];
        http_response_code($response_code);
    } else {
        http_response_code(200);
    }
    echo json_encode($dataArray);  // Retorna en formato json el arreglo de la respuesta (como cadena)
} else {
    header('Content-Type: application/json');
    $dataArray = $response->error_405();
    echo json_encode($dataArray);
}
