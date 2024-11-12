<?php
require_once 'db.php';
require_once 'userController.php';
require_once 'operationController.php';

// Parse the request URI and method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

// Routes
if ($method === 'POST' && $uri === '/register') {
    registerUser();

} elseif ($method === 'POST' && $uri === '/login') {
    loginUser();

} elseif ($method === 'POST' && $uri === '/get-divisions') {
    getDivisions();

} elseif ($method === 'POST' && $uri === '/generate-divisions') {
    generateDivisions();

} elseif ($method === 'POST' && $uri === '/check-division') {
    checkDivision();

} else {
    echo json_encode(['error' => 'Ruta no encontrada']);
    http_response_code(404);
}
?>