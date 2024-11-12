<?php
// db.php
function getDatabaseConnection() {
    $db = new PDO('sqlite:' . __DIR__ . '/db.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}
?>
