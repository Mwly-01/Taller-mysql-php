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
                break;  //     {
                          //     "nombre":"MIERDA"
                            // } ingresar dato en el posman para quer veas que se realiza la accion 
            case 'PUT':
                validarID($id);
                
                $data = json_decode(file_get_contents('php://input'),true);
                
                
                if (!$data || empty($data['nombre'])) {
                    echo json_encode(['error' => 'El campo nombre es obligatorio']);
                    break;
                }
                
                $stmt = $pdo->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
                $stmt->execute([$data['nombre'], $id]);
                
                echo json_encode(['mensaje' => 'Categoría actualizada correctamente']);
                break;
                       //{
                    //     "nombre":"meliza"  
                      // } se tiene que escirbir esto en un postman
            case 'DELETE':
                validarID($id);
                $stmt = $pdo->prepare("SELECT * FROM categorias WHERE id = ?");
                $stmt->execute([$id]);
                $categoria = $stmt->fetch(PDO::FETCH_ASSOC);  // Cambié $producto por $categoria
                
                if (!$categoria) {
                    http_response_code(404);
                    echo json_encode([
                        'error' => 'Categoría no encontrada',
                        'code' => 404,
                        'errorUrl' => 'https://http.cat/404'
                    ]);
                    exit;
                }
                
                $stmt = $pdo->prepare("DELETE FROM categorias WHERE id = ?");
                $stmt->execute([$id]);
                
                echo json_encode($categoria);  
        }
    case 'productos':
        switch ($method) {
            case 'GET':
                if($id){ 
                    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
                    $stmt->execute([$id]);
                    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    echo json_encode(($productos));
                }else{
                    $stmt = $pdo->prepare("SELECT * FROM productos");
                    $stmt->execute();
                    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    echo json_encode($productos);
                }
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                    if ($data === null) {
                    http_response_code(400);
                    echo json_encode([
                        'error' => 'JSON inválido o no enviado',
                        'code' => 400,
                        'errorUrl' => 'https://http.cat/400'
                    ]);
                    exit;
                }
                $stmt = $pdo->prepare("INSERT INTO productos(nombre,precio,categoria_id)VALUES(?,?,?)");
                $stmt->execute([$data['nombre'], $data['precio'],$data['categoria_id']]);
                http_response_code(201);
                $data['id'] = $pdo->lastInsertId();
                echo json_encode($data);
                break;
        break;

}

}