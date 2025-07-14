<?php

require_once "src/db.php";

$method = $_SERVER['REQUEST_METHOD'];
$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

$recurso = $url[0] ?? null;
$id = $url[1] ?? null;

header('Content-Type: application/json');

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
switch ($recurso) {
    case 'categorias':
        switch ($method) {
            case 'GET':
                if($id){
                    $stmt = $pdo->prepare("SELECT * FROM categorias WHERE id = ?");
                    $stmt->execute([$id]);
                    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    echo json_encode($categorias);
                }else{
                    $stmt = $pdo->prepare("SELECT * FROM categorias");
                    $stmt->execute();
                    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    echo json_encode($categorias);
                }
                break;
            case 'POST':    
                $data = json_decode(file_get_contents('php://input'),true);
                $stmt = $pdo->prepare("INSERT INTO categorias(nombre) VALUES(?)");
                $stmt->execute([
                    $data['nombre']
                ]);
                http_response_code(201);
                $data['id'] = $pdo->lastInsertId();
                echo json_encode($data);
                break;
            case '':
                # code...
                break; 
        }
        break;
}



