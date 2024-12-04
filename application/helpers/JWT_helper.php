<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function generateJWT($payload, $key, $algorithm = 'HS256') {
    return JWT::encode($payload, $key, $algorithm);
}

function decodeJWT($jwt, $key, $algorithm = 'HS256') {
    return JWT::decode($jwt, new Key($key, $algorithm));
}
