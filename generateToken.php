<?php

require('src/JWT.php');

// $username = filter_input(INPUT_POST, 'username');

$key = "exemplo_de_chave";
$payload = ["username" => "frankwsb"];

$token = JWT::encode($payload, $key);

echo "Token: $token";
?>
