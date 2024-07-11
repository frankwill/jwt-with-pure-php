<?php 
require ("src/JWT.php");

$key = "exemplo_de_chave";
if(isset($_POST['token']) ) {
  $token = $_POST["token"];
  return JWT::validate($token, $key);
}