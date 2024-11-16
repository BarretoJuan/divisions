<?php
require_once 'db.php';
require_once 'userController.php';
require_once 'operationController.php';

// Parse the request URI and method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Encabezados CORS
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:5173"); // Origen permitido
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Manejo de solicitudes preflight (CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // OK para preflight
    exit;
}

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
} elseif ($method === "GET" && $uri === '/') {
    echo json_encode(['message' => 'Welcome to the API']);
} else {
    echo json_encode(['error' => 'Ruta no encontrada']);
    http_response_code(404);
}
?>
