<?php
require_once __DIR__ . "/../cors.php";
require_once __DIR__ . "/../db.php";

function getObs($salaire) {
    if ($salaire < 1000) return "mediocre";
    if ($salaire <= 5000) return "moyen";
    return "grand";
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        $stmt = $pdo->query("SELECT numEmp, nom, salaire FROM employe ORDER BY nom");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as &$row) {
            $row['salaire'] = (float) $row['salaire'];
            $row['obs'] = getObs($row['salaire']);
        }
        echo json_encode($rows);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $numEmp = trim($data['numEmp'] ?? '');
        $nom = trim($data['nom'] ?? '');
        $salaire = $data['salaire'] ?? null;

        if ($numEmp === '' || $nom === '' || $salaire === null) {
            http_response_code(400);
            echo json_encode(["message" => "Insertion echouee"]);
            break;
        }

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO employe (numEmp, nom, salaire) VALUES (:numEmp, :nom, :salaire)"
            );
            $stmt->execute([
                ':numEmp' => $numEmp,
                ':nom' => $nom,
                ':salaire' => $salaire,
            ]);
            http_response_code(201);
            echo json_encode(["message" => "Insertion reussie"]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["message" => "Insertion echouee"]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $numEmp = trim($data['numEmp'] ?? '');
        $nom = trim($data['nom'] ?? '');
        $salaire = $data['salaire'] ?? null;

        if ($numEmp === '' || $nom === '' || $salaire === null) {
            http_response_code(400);
            echo json_encode(["message" => "Modification echouee"]);
            break;
        }

        try {
            $stmt = $pdo->prepare(
                "UPDATE employe SET nom = :nom, salaire = :salaire WHERE numEmp = :numEmp"
            );
            $stmt->execute([
                ':nom' => $nom,
                ':salaire' => $salaire,
                ':numEmp' => $numEmp,
            ]);
            if ($stmt->rowCount() > 0) {
                echo json_encode(["message" => "Modification reussie"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Modification echouee"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["message" => "Modification echouee"]);
        }
        break;

    case 'DELETE':
        $numEmp = $_GET['numEmp'] ?? '';

        if ($numEmp === '') {
            http_response_code(400);
            echo json_encode(["message" => "Suppression echouee"]);
            break;
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM employe WHERE numEmp = :numEmp");
            $stmt->execute([':numEmp' => $numEmp]);
            if ($stmt->rowCount() > 0) {
                echo json_encode(["message" => "Suppression reussie"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Suppression echouee"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["message" => "Suppression echouee"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Methode non autorisee"]);
}