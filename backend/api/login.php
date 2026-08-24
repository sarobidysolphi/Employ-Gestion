<?php
require_once __DIR__ . "/../cors.php";

// Identifiants de demonstration. A remplacer par une verification
// en base (table utilisateurs + mot de passe hache) pour un vrai projet.
$VALID_USER = "admin";
$VALID_PASS = "admin123";

$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"] ?? "";
$password = $data["password"] ?? "";

if ($username === $VALID_USER && $password === $VALID_PASS) {
    http_response_code(200);
    echo json_encode([
        "message" => "Connexion reussie",
        "token" => bin2hex(random_bytes(16)),
        "user" => ["username" => $username],
    ]);
} else {
    http_response_code(401);
    echo json_encode(["message" => "Identifiants incorrects"]);
}