<?php

require_once 'config.php';

function generateJWT($data) {
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $payload = json_encode(array_merge($data, ['exp' => time() + JWT_EXPIRATION_TIME]));
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
}

function verifyJWT($jwt) {
    // Extract JWT token from Bearer prefix if present
    $jwtParts = explode(' ', $jwt);
    if (count($jwtParts) !== 2 || $jwtParts[0] !== 'Bearer') {
        return null;
    }
    $jwt = $jwtParts[1];

    list($base64UrlHeader, $base64UrlPayload, $signature) = explode('.', $jwt);
    $data = json_decode(base64_decode($base64UrlPayload), true);
    $signatureProvided = base64_decode(str_replace(['-', '_'], ['+', '/'], $signature));
    $validSignature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
    return hash_equals($validSignature, $signatureProvided) && $data['exp'] >= time() ? $data : null;
}

?>
