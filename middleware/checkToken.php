<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function tokenValid()
{
    if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
        header('HTTP/1.0 400 Bad Request');
        echo 'Token not found in request';
        exit;
    }        

    $jwt = $matches[1];
    if (! $jwt) {
        header('HTTP/1.0 400 Bad Request');
        exit;
    }

    global $tokenSecretKey;
    $secretKey = $tokenSecretKey['tokenSecretKey'];
    $token = JWT::decode($jwt, new Key($secretKey, 'HS512'));
    $now     = new DateTimeImmutable();
    $serverName = 'localhost';

    if ($token->iss !== $serverName ||
        $token->nbf > $now->getTimestamp() ||
        $token->exp < $now->getTimestamp())
    {
        header('HTTP/1.1 401 Unauthorized');
        exit;
    }

    return true;
}

?>