<?php
require_once 'db.php';

function registerUser() {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['username'];
    $password = $data['password'];

    if (strlen($username) < 4 || strlen($username) > 15) {
        echo json_encode(["error" => "El nombre de usuario debe tener entre 4 y 15 caracteres"]);
        return;
    }

    if (strlen($password) < 8) {
        echo json_encode(["error" => "La contraseña debe tener al menos 8 caracteres"]);
        return;
    }

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