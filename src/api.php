<?php

require_once "db.php";

// está haciendo: GET, POST, PUT, DELETE
$method = $_SERVER['REQUEST_METHOD'];

//separa por segmentos
$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Guarda el primer segmento de la URL (recurso)
$recurso = $url[0];

// Guarda  (ID si existe)
$id = $url[1] ?? null;

header('Content-Type: application/json'); // La respuesta será JSON

// EndPoint: Valida que el recurso exista
if ($recurso !== 'productos' && $recurso !== 'categorias' && $recurso !== 'promociones' && $recurso !== 'productos-promocion') {
    http_response_code(404);
    echo json_encode([
        'error' => 'Recurso no encontrado',
        'code' => 404,
        'errorUrl' => 'https://http.cat/404'
    ]);
    exit;
}

//aparatado de la API

