<?php

require('src/JWT.php');

$name = filter_input(INPUT_POST, 'name');
$company = filter_input(INPUT_POST, 'company');
$secret = filter_input(INPUT_POST, 'secret');

$payload = [
  "name" => $name,
  "company" => $company,
];

$token = JWT::encode($payload, $secret);

$response = [
  "payload" => $payload,
  "token" => $token
];

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);