<?php
// Parametres de connexion a la base de donnees.
// Adapte host / dbname / user / password a ton environnement local.
$host = "localhost";
$dbname = "employes_db";
$user = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Connexion a la base de donnees echouee"]);
    exit;
}