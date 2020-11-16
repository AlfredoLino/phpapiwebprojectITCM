<?php
require_once '../../network/response.php';
require_once 'controller.php';

$response = new response();
$controller = new controller();

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['page_number']) && isset($_GET['quantity'])) {   /* http://localhost/plataforma_escolar/components/group/network.php?page_number=1&quantity=100 */
        $page = $_GET['page_number'];
        $quantity = $_GET['quantity'];
        $listGroups = $controller->listGroups($page, $quantity);
        header('Content-Type: application/json');
        echo json_encode($listGroups);
        http_response_code(200);
    } else if(isset($_GET['id'])) {     /* http://localhost/plataforma_escolar/components/group/network.php?id=12345      id = _id */
        $id = $_GET['id'];
        $dataGroup = $controller->getGroup($id);
        header('Content-Type: application/json');
        echo json_encode($dataGroup);
        http_response_code(200);
    }

} else if($_SERVER['REQUEST_METHOD'] == 'POST') {   /* http://localhost/plataforma_escolar/components/professor/network.php */
    /* enviar json ej.
    {
	"id" : "56784",
    "subject" : "Matemáticas",
    "schedule" : "15:00-16:00",
    "professor" : "12345",
    "token" : "rgbkrgewlhgelwa"
    } */
    // Recibir datos
    $postBody = file_get_contents('php://input');
    // Enviar los datos al controlador
    $dataArray = $controller->addGroup($postBody);

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
        "id" : "56784",
        "subject" : "Ciencias Naturales",
        "schedule" : "16:00-17:00",
        "professor" : "54321",
        "token" : "rgbkrgewlhgelwa"
       }
     *
     */
    // Recibir datos
    $postBody = file_get_contents('php://input');

    // Enviar los datos al controlador
    $dataArray = $controller->updateGroup($postBody);

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
	    "id" : "56784",
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
    $dataArray = $controller->removeGroup($postBody);

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

