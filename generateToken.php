<?php

require('src/JWT.php');

// $username = filter_input(INPUT_POST, 'username');

$payload = ["username" => "frankwsb"];

$token = JWT::encode($payload);

echo "Token: $token";
?>
