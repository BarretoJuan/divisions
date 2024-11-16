<?php
require_once 'db.php';

function registerUser() {
    $data = json_decode(file_get_contents("php://input"), true);
    error_log("aki el pepe: " . print_r($data, true));

    $username = $data['username'];
    $password = $data['password'];


    // Hashear contraseña después de validarla
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $db = getDatabaseConnection();
    $stmt = $db->prepare("INSERT INTO User (username, password) VALUES (:username, :password)");

    try {
        $stmt->execute(['username' => $username, 'password' => $hashedPassword]);
        echo json_encode(["message" => "Usuario registrado satisfactoriamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Ese nombre de usuario ya existe"]);
    }
}

function loginUser() {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['username'];
    $password = $data['password'];

    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT * FROM User WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode(["message" => "Inicio de sesión satisfactorio"]);
    } else {
        echo json_encode(["error" => "Credenciales inválidas"]);
    }
}
?>