<?php
require_once '../../network/response.php';
require_once 'store.php';

class controller {
    private $id;
    private $subject;
    private $schedule;
    private $professor;
    private $token;

    public function addGroup($json) {
        $response = new response();
        $store = new store();
        $data = json_decode($json, true); /* Convertimos el json en un array asociativo */

        if(!isset($data['token'])) {
            return $response->error_401();
        } else {
            $this->token = $data['token'];

            if($this->token) {  /* Validar campos obligatorios */
                if (!isset($data['id']) || !isset($data['subject']) || !isset($data['schedule']) || !isset($data['professor'])) {
                    return $response->error_400();
                } else {
                    $this->id = $data['id'];
                    $this->subject = $data['subject'];
                    $this->schedule = $data['schedule'];
                    $this->professor = $data['professor'];

                    $result_query = $store->insert($this->id, $this->subject, $this->schedule, $this->professor);

                    if($result_query) {
                        $results = $response->response;
                        $results['result'] = array(
                            "groupID" => $result_query
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

    public function listGroups($page_number, $quantity) {
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

    public function getGroup($id) {
        $store = new store();
        return $store->get($id);
    }

    public function updateGroup($json) {
        $response = new response();
        $data = json_decode($json, true);
        $store = new store();

        if(!isset($data['token'])) {
            return $response->error_401();
        } else {
            $this->token = $data['token'];

            if ($this->token) {  /* Validar campos obligatorios */
                if (!isset($data['id']) || !isset($data['subject']) || !isset($data['schedule']) || !isset($data['professor'])) {
                    return $response->error_400();
                } else {
                    $this->id = $data['id'];
                    $this->subject = $data['subject'];
                    $this->schedule = $data['schedule'];
                    $this->professor = $data['professor'];

                    $result_query = $store->update($this->id, $this->subject, $this->schedule, $this->professor);

                    if ($result_query) {
                        $results = $response->response;
                        $results['result'] = array(
                            "groupID" => $this->id
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

    public function removeGroup($json) {
        $response = new response();
        $store = new store();
        $data = json_decode($json, true);

        if(!isset($data['token'])) {
            return $response->error_401();
        } else {
            $this->token = $data['token'];

            if($this->token) {
                if (!isset($data['id'])) { // Validar campos obligatorios
                    return $response->error_400();
                } else {
                    $this->id = $data['id'];
                    $result = $store->delete($this->id);

                    if ($result) {
                        $results = $response->response;
                        $results['result'] = array(
                            "groupID" => $this->id
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

