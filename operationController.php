<?php
require_once 'db.php';

function getDivisions() {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['username'];
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT * FROM Operation WHERE user_id= (SELECT id FROM User WHERE username= :username )");
    $stmt->execute(['username' => $username]);
    $operations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($operations);
}

function generateDivisions() {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['username'];

    $db = getDatabaseConnection();
    $stmtUser = $db->prepare("SELECT id FROM User WHERE username = :username");
    $stmtUser->execute(['username' => $username]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $userId = $user['id'];
        $db->prepare("DELETE FROM Operation WHERE user_id = :user_id")->execute(['user_id' => $userId]);

        $stmtInsert = $db->prepare("INSERT INTO Operation (divisor, dividend, user_id, is_solved) VALUES (?, ?, ?, 0)");
        $generatedCount = 0;

        while ($generatedCount < 27) { //número de operaciones a crear
            $divisor = rand(2, 9); // Genera un divisor de un dígito (2-9)
            $dividend = rand(10, 99); // Genera un dividendo de dos dígitos (10-99)
            
            if ($dividend % $divisor == 0) { // Verifica que el resultado sea entero
                $stmtInsert->execute([$divisor, $dividend, $userId]);
                $generatedCount++;
            }
        }
        return; // Doesn't return anything
    } else {
        echo json_encode(["error" => "Usuario no encontrado"]);
    }
}

function checkDivision() {
    $data = json_decode(file_get_contents("php://input"), true);
    $operationId = $data['operation_id'];
    $userResult = $data['result'];

    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT divisor, dividend FROM Operation WHERE id = :operation_id");
    $stmt->execute(['operation_id' => $operationId]);
    $operation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($operation) {
        $correctResult = $operation['dividend'] / $operation['divisor'];
        if ($userResult == $correctResult) { // Verifica el resultado exacto sin margen de error
            $db->prepare("UPDATE Operation SET is_solved = 1 WHERE id = :operation_id")->execute(['operation_id' => $operationId]);
            echo json_encode(["message" => "Resultado Correcto!"]);
        } else {
            echo json_encode(["error" => "Resultado incorrecto."]);
        }
    } else {
        echo json_encode(["error" => "Operación no encontrada"]);
    }
}

?>
