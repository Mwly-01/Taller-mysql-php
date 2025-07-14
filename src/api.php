<?php

require_once "db.php";

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

$recurso = $url[0] ?? null;
$id = $url[1] ?? null;

// Lista de recursos válidos
$recursos_validos = ['productos', 'categorias', 'promociones', 'productos-promocion'];

// Si el recurso no es válido
if (!in_array($recurso, $recursos_validos)) {
    responderError(404, 'Recurso no encontrado');
}

// ------------------------- FUNCIONES AUXILIARES -----------------------------

function responderError($codigo, $mensaje) {
    http_response_code($codigo);
    echo json_encode([
        'error' => $mensaje,
        'code' => $codigo,
        'errorUrl' => "https://http.cat/$codigo"
    ]);
    exit;
}

function validarID($id) {
    if (!$id) {
        responderError(400, 'ID requerido');
    }
}
//categoria GET
switch ($recurso){
    case 'categoria':
        switch($method){
            case GET:
                if ($id){
                $stmt = $pdo->prepare("SELECT nombre AS tipo de categoria FROM categorias WHERE id = ?");
                $stmt->execute([$id]);
                $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($categoria) {
                    echo json_encode($categoria);
                }   else {
                    http_response_code(404);
                    echo json_encode(['error' => 'no se encontro la categoria']);
                } 
            }else{
                $stmt =$pdo->prepare("SELECT nombre AS tipo de categoria FROM categorias");
                $stmt->$execute();
                $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($response);
            }
        }
}