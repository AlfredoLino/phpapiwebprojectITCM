<?php

class response {

    public $response = array(
        'status' => 'ok',
        'result' => array()
    );

    public function error_405() {   // Resultado de una solicitud por un método no permitido    ej. /productos (post)
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_id' => '405',
            'error_msg' => 'Método no permitido'
        );
        return $this->response;
    }

    public function error_200($msg = "Datos incorrectos") {   //
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_id' => '200',
            'error_msg' => $msg
        );
        return $this->response;
    }

    public function error_400() {   //
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_id' => '400',
            'error_msg' => 'Datos enviados incompletos o con formato incorrecto'
        );
        return $this->response;
    }

    public static function error400(){
        return array('status'=>"error", 'result' => array("error_id" => "400", 'error_msg' => 'Datos enviados incompletos o con formato incorrecto'));
    }
    public static function error401(){
        return array('status'=>"error", 'result' => array("error_id" => "401", 'error_msg' => 'Informacion incorrecta'));
    }

    public function error_500($msg = "Error del servidor") {   //
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_id' => '500',
            'error_msg' => $msg
        );
        return $this->response;
    }

    public function error_401($msg = "No autorizado") {   //
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_id' => '401',
            'error_msg' => $msg
        );
        return $this->response;
    }

    public static function succes201($msg){
        return array(
            "status" => 201,
            "message" => $msg
        );
    }
}