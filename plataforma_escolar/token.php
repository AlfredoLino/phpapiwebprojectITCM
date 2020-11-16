<?php
use Firebase\JWT\JWT;

require_once './php-jwt-master/src/JWT.php';

    class token {
        private $time;
        private $key;
        private $email;
        private $password;
        private $userID;
        
        function __construct($userID, $email, $password) {
            $this->time = time();
            $this->key = 'my_secret_key';
            $this->email = $email;
            $this->password = $password;
            $this->userID = $userID;
        }

        public function generarToken() {
            $token = array(
                'iat' => $this->time, // Tiempo que inició el token
                'exp' => $this->time + (60*60), // Tiempo que expirará el token (+1 hora)
                'data' => array( // información del usuario
                    'password' => $this->password,
                    'email' => $this->email,
                    'userID' => $this->userID
                )
            );
        
            $jwt = JWT::encode($token, $this->key);
            echo $jwt;
            $token = array(
                "token" => $jwt
            );

            return json_encode($token);
        }
    }

    /*$data = JWT::decode($jwt, $this->key, array('HS256'));

    var_dump($data);
    var_dump($jwt);*/

?>