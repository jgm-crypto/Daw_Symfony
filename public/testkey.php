<?php
// public/testkey.php

$publicKeyPath = __DIR__ . '/../config/jwt/public.pem';
if (file_exists($publicKeyPath)) {
    echo file_get_contents($publicKeyPath);
} else {
    echo 'El archivo no existe.';
}
