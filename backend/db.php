<?php
// Parametres de connexion a la base de donnees (MySQL de Laragon).
$host = "localhost";
$port = 3307;
$dbname = "employes_db";
$user = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Connexion a la base de donnees echouee"]);
    exit;
}