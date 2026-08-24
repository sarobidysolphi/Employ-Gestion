<?php
require_once __DIR__ . "/../cors.php";
require_once __DIR__ . "/../db.php";

$stmt = $pdo->query(
    "SELECT COALESCE(SUM(salaire),0) AS total,
            COALESCE(MIN(salaire),0) AS minimum,
            COALESCE(MAX(salaire),0) AS maximum
     FROM employe"
);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    "total" => (float) $row['total'],
    "minimum" => (float) $row['minimum'],
    "maximum" => (float) $row['maximum'],
]);