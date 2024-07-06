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

    $header = $arrayParts[0];
    $payload = $arrayParts[1];
    $signature = $arrayParts[2];

    $decode = json_decode(base64_decode($payload), true);

    $valid = hash_hmac("sha256", "$header.$payload", "senha-secreta", true);

    if(count($arrayParts) != 3) {
      return "Inválido";
    } else if($decode["exp"] < time()) {
      return "Expirado";
    } else if ($signature == $valid) {
      return "Permissão negada";
    } else {
      return "$header.$payload.$signature";
    }
  }
}
