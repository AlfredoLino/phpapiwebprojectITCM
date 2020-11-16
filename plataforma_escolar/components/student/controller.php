<?php
require_once '../../network/response.php';
require_once 'store.php';

class controller {
    private $control_number;
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $token;

    public function addStudent($json) {
        $response = new response();
        $store = new store();
        $data = json_decode($json, true); /* Convertimos el json en un array asociativo */

        if(!isset($data['token'])) {
            return $response->error_401();
        } else {
            $this->token = $data['token'];

            if($this->token) {  /* Validar campos obligatorios */
                if (!isset($data['control_number']) || !isset($data['first_name']) || !isset($data['last_name']) || !isset($data['email']) || !isset($data['password'])) {
                    return $response->error_400();
                } else {
                    $this->control_number = $data['control_number'];
                    $this->first_name = $data['first_name'];
                    $this->last_name = $data['last_name'];
                    $this->email = $data['email'];
                    $this->password = $data['password'];

                    $result_query = $store->insert($this->control_number, $this->first_name, $this->last_name, $this->email, $this->password);

                    if($result_query) {
                        $results = $response->response;
                        $results['result'] = array(
                            "studentID" => $result_query
                        );
                        return $results;
                    } else {
                        return $response->error_500();
                    }
                }
            } else {
                return $response->error_401("El Token enviado es inválido o ha caducado");
            }
        }

    }

    public function listStudents($page_number, $quantity) {
        /* page_number = número de división de los registros
         quantity = cantidad de filas por página */
        $start = 0;
        if($page_number > 1) {   // Si página es la 2 o en adelante
            $start = ($quantity * ($page_number - 1)) + 1;   // ej. 100 * (2 - 1) + 1 = 101
            $quantity *= $page_number;   // ej. 100 * 2 = 200    entonces: inicio = 101 , cantidad = 200     101-200
        }

        $store = new store();
        return $store->getList($start, $quantity);
    }

    public function getStudent($control_number) {
        $store = new store();
        return $store->get($control_number);
    }

    public function updateStudent($json) {
        $response = new response();
        $data = json_decode($json, true);
        $store = new store();

        if(!isset($data['token'])) {
            return $response->error_401();
        } else {
            $this->token = $data['token'];

            if ($this->token) {  /* Validar campos obligatorios */
                if (!isset($data['control_number']) || !isset($data['first_name']) || !isset($data['last_name']) || !isset($data['email'])) {
                    return $response->error_400();
                } else {
                    $this->control_number = $data['control_number'];
                    $this->first_name = $data['first_name'];
                    $this->last_name = $data['last_name'];
                    $this->email = $data['email'];

                    $result_query = $store->update($this->control_number, $this->first_name, $this->last_name, $this->email);

                    if ($result_query) {
                        $results = $response->response;
                        $results['result'] = array(
                            "studentID" => $this->control_number
                        );
                        return $results;
                    } else {
                        return $response->error_500();
                    }
                }
            } else {
                return $response->error_401("El Token enviado es invalido o ha caducado");
            }
        }
    }

    public function removeStudent($json) {
        $response = new response();
        $store = new store();
        $data = json_decode($json, true);

        if(!isset($data['token'])) {
            return $response->error_401();
        } else {
            $this->token = $data['token'];

            if($this->token) {
                if (!isset($data['control_number'])) { // Validar campos obligatorios
                    return $response->error_400();
                } else {
                    $this->control_number = $data['control_number'];
                    $result = $store->delete($this->control_number);

                    if ($result) {
                        $results = $response->response;
                        $results['result'] = array(
                            "studentID" => $this->control_number
                        );
                        return $results;
                    } else {
                        return $response->error_500();
                    }
                }
            } else {
                return $response->error_401("El Token enviado es invalido o ha caducado");
            }
        }
    }

}

