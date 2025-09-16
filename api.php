<?php
header("Content-Type: application/json");
require_once "database.php";

$table = $_GET["table"] ?? null;
$action = $_GET["action"] ?? "list";

if (!$table) {
    echo json_encode(["error" => "No table specified"]);
    exit;
}

switch ($action) {
    case "list":
        $stmt = $pdo->query("SELECT * FROM $table");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case "create":
        $data = json_decode(file_get_contents("php://input"), true);
        $keys = array_keys($data);
        $fields = implode(",", $keys);
        $placeholders = implode(",", array_fill(0, count($keys), "?"));
        $stmt = $pdo->prepare("INSERT INTO $table ($fields) VALUES ($placeholders)");
        $stmt->execute(array_values($data));
        echo json_encode(["success" => true, "id" => $pdo->lastInsertId()]);
        break;

    case "update":
        $id = $_GET["id"] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);
        $set = implode(",", array_map(fn($k) => "$k=?", array_keys($data)));
        $stmt = $pdo->prepare("UPDATE $table SET $set WHERE ID=?");
        $stmt->execute([...array_values($data), $id]);
        echo json_encode(["success" => true]);
        break;

    case "delete":
        $id = $_GET["id"] ?? null;
        $stmt = $pdo->prepare("DELETE FROM $table WHERE ID=?");
        $stmt->execute([$id]);
        echo json_encode(["success" => true]);
        break;

    default:
        echo json_encode(["error" => "Unknown action"]);
}
