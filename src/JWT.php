<?php

date_default_timezone_set('America/Sao_Paulo');

class JWT
{
  /**
   * Espera um JSON do cabeçalho, carga útil e assinatura,
   * transforma esses dados em base64 e substitui algums caracteres considerados
   * inválidos pelos requisitos JWT.
   * 
   * @param string $jsonEncode Espera a representação JSON em formato de string.
   * @return string Retorna o dado em string base64.
   */
  public static function base64Encode($jsonEncode): string
  {
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($jsonEncode));
  }

  /**
   * Codifica a carga útil com a palavra chave passada e retorna um
   * token válido por 10 segundos.
   * 
   * @param array $payload Valores a serem guardados na carga útil.
   * @param string $key Palavra chave.
   * @return string Retorna um token válido.
   */
  public static function encode(array $payload, string $key): string
  {
    $header = self::base64Encode(json_encode(["alg" => "HS256", "typ" => "JWT"]));

    $payloadDefault = [
      "iat" => time(),
      "exp" => time() + (60 * 60),
      // "exp" => time() + 10,
    ];
    $payload = array_merge($payloadDefault, $payload);
    $payload = self::base64Encode(json_encode($payload));

    $signature = hash_hmac("sha256", "$header.$payload", $key, true);
    $signature = self::base64Encode($signature);

    $token = "$header.$payload.$signature";

    return $token;
  }

  /**
   * Decodifica o token e a palavra chave recebido pelo cliente, 
   * faz a validação das partes do token, refaz a codificação 
   * se o mesmo for válido e devolve para o cliente.
   * 
   * @param string $token Token que o cliente gerou.
   * @param string $key Palavra chave.
   * 
   * @return string Retorna o token validado.
   */
  public static function validate(string $token, string $key)
  {
    $arrayParts = explode(".", $token);

    $header = $arrayParts[0];
    $payload = $arrayParts[1];
    $signature = $arrayParts[2];

    $decode = json_decode(base64_decode($payload), true);

    $valid = hash_hmac("sha256", "$header.$payload", $key, true);
    $valid = self::base64Encode($valid);

    $response = array();
    if(count($arrayParts) != 3) {
      $response["msg"] = "Token inválido";
      return $response;
    } else if($decode["exp"] < time()) {
      $response["msg"] = "Token expirado";
      return $response;
    } else if ($signature !== $valid) {
      $response["msg"] = "Permissão negada";
      return $response;
    } else {
      $response["token"] = $header.$payload.$signature;
      $response["msg"] = "Token válido";
      return $response;
    }
  }
}
