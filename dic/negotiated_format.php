<?php

// Cargar autoloader si no está cargado
if (!class_exists('Negotiation\Negotiator')) {
    require __DIR__ . '/../autoloader.php';
}

/**
 * Returns the best negotiated format according to RFC 7231.
 */
return (new \Negotiation\Negotiator())
    ->getBest($_SERVER["HTTP_ACCEPT"], ['text/html', 'application/json'])
    ->getValue();
