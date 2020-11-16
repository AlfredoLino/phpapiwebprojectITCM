<?php
require_once '../../network/response.php';
require_once 'controller.php';

$response = new response();
$controller = new controller();

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['page_number']) && isset($_GET['quantity'])) {   /* http://localhost/plataforma_escolar/components/student/network.php?page_number=1&quantity=100 */
        $page = $_GET['page_number'];
        $quantity = $_GET['quantity'];
        $listStudents = $controller->listStudents($page, $quantity);
        header('Content-Type: application/json');
        echo json_encode($listStudents);
        http_response_code(200);
    } else if(isset($_GET['id'])) {     /* http://localhost/plataforma_escolar/components/student/network.php?id=12345      id = ncontrol */
        $control_number = $_GET['id'];
        $dataStudent = $controller->getStudent($control_number);
        header('Content-Type: application/json');
        echo json_encode($dataStudent);
        http_response_code(200);
    }

} else if($_SERVER['REQUEST_METHOD'] == 'POST') {   /* http://localhost/plataforma_escolar/components/student/network.php */
    /* enviar json ej.
    {
	"control_number" : "54392",
    "first_name" : "Albert",
    "last_name" : "Hernandez",
      "email" : "ricardo@gmail.com",
        "password" : "123456",
        "token" : "rgbkrgewlhgelw"
    } */
    // Recibir datos
    $postBody = file_get_contents('php://input');
    // Enviar los datos al controlador
    $dataArray = $controller->addStudent($postBody);

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
	    "control_number" : "54392",
        "first_name" : "Alberto",
        "last_name" : "Perez",
        "email" : "ricardo@gmail.com",
        "token" : "rgbkrgewlhgelw"
        }
     *
     */
    // Recibir datos
    $postBody = file_get_contents('php://input');

    // Enviar los datos al controlador
    $dataArray = $controller->updateStudent($postBody);

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
	    "control_number" : "54392",
        "token" : "rgbkrgewlhgelw"
        }
     */
    $headers = getallheaders();
    if(isset($headers["token"]) && isset($headers["studentId"])){
        //recibimos los datos enviados por el header
        $send = array(
            "token" => $headers["token"],
            "studentId" =>$headers["studentId"]
        );
        $postBody = json_encode($send);
    } else {
        // Recibir datos por el body
        $postBody = file_get_contents('php://input');
    }

    // Enviar los datos al controlador
    $dataArray = $controller->removeStudent($postBody);

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