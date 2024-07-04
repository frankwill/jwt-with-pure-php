<?php

date_default_timezone_set('America/Sao_Paulo');

class JWT
{
  public static function base64Encode($jsonEncode)
  {
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($jsonEncode));
  }

  public static function encode(array $payload)
  {
    $header = self::base64Encode(json_encode(["alg" => "HS256", "typ" => "JWT"]));

    $payloadDefault = [
      "iat" => time(),
      // "exp" => time() + (24 * 60 * 60),
      "exp" => time() + 10,
    ];
    $payload = array_merge($payloadDefault, $payload);
    $payload = self::base64Encode(json_encode($payload));

    $signature = hash_hmac("sha256", "$header.$payload", 'senha-secreta', true);
    $signature = self::base64Encode($signature);

    $token = "$header.$payload.$signature";

    return $token;
  }

  public static function validate(string $token)
  {
    $arrayParts = explode(".", $token);
    
    // if (count($arrayParts) != 3) {
    //   echo "Token inválido";
    //   exit();
    // }

    // $decode = json_decode(base64_decode($arrayParts[1]), true);

    // if ($decode["exp"] < time()) {
    //   echo "sim";
    // } else {
    //   echo "nao";
    // }
    // exit();

    // $header = $arrayParts[0];
    // $payload = $arrayParts[1];
    // $signature = $arrayParts[2];

    // $valid = hash_hmac('sha256', "$header.$payload", 'senha-secreta', true);
    // $valid = self::base64Encode($valid);

    // if ($signature == $valid) {
    //   return $token = "$header.$payload.$signature";
    // } else {
    //   return false;
    // }
  }
}
