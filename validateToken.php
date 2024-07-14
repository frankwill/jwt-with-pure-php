<?php 
require ("src/JWT.php");

$key = "my_secret_key";
if(isset($_POST['token']) ) {
  $token = $_POST["token"];
  $validToken = JWT::validate($token, $key);
  echo json_encode($validToken);
}