<?php

use Firebase\JWT\JWT;

$_POST = json_decode(file_get_contents('php://input'));

$requisites = ["nombre", "apellidos", "email", "celular", "pass"];
