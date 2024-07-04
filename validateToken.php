<?php 
require ("src/JWT.php");

$token = $_POST["token"];

$result = JWT::validate($token);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validador de Token JWT</title>
</head>
<body>
  <h1>Validador de Token</h1>
  <form method="POST">
    <label for="token">Token</label>
    <input id="token" type="text" name="token">
    <input type="submit" value="Validar">
  </form>
  
</body>
</html>