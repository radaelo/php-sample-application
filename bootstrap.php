<?php

// HABILITAR PARA DEPURACIÓN (eliminar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/autoloader.php';
require __DIR__ . '/error_handler.php';

// Configuración de seguridad
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');

// Configuración de zona horaria
date_default_timezone_set('UTC');

// Habilitar CORS para desarrollo
if (getenv('APP_ENV') === 'development') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
}
