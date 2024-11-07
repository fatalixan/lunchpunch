<?php
require 'database.php';

header("Content-Type: application/json");

// Убедимся, что метод запроса поддерживается
$requestMethod = $_SERVER['REQUEST_METHOD'];
$entity = isset($_GET['entity']) ? $_GET['entity'] : null;
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

// Подключаемся к базе данных
$pdo = connectDatabase();

// Проверка сущности (таблицы) и выполнение CRUD
switch ($entity) {
    case 'staff_schedule':
        handleStaffSchedule($requestMethod, $pdo, $id);
        break;
    case 'staff':
        handleStaff($requestMethod, $pdo, $id);
        break;
    case 'schedule':
        handleSchedule($requestMethod, $pdo, $id);
        break;
    default:
        echo json_encode(["error" => "Invalid entity specified"]);
}

function handleStaffSchedule($method, $pdo, $id) {
    switch ($method) {
        case 'GET':
            $stmt = $id ? $pdo->prepare("SELECT * FROM StaffSchedule WHERE id = ?") : $pdo->query("SELECT * FROM StaffSchedule");
            $stmt->execute($id ? [$id] : []);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $stmt = $pdo->prepare("INSERT INTO StaffSchedule (job_title, rate, bonus, description) VALUES (?, ?, ?, ?)");
            $stmt->execute([$data['job_title'], $data['rate'], $data['bonus'], $data['description']]);
            echo json_encode(["success" => true, "id" => $pdo->lastInsertId()]);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            $stmt = $pdo->prepare("UPDATE StaffSchedule SET job_title = ?, rate = ?, bonus = ?, description = ? WHERE id = ?");
            $stmt->execute([$data['job_title'], $data['rate'], $data['bonus'], $data['description'], $id]);
            echo json_encode(["success" => true]);
            break;
        case 'DELETE':
            $stmt = $pdo->prepare("DELETE FROM StaffSchedule WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(["success" => true]);
            break;
        default:
            echo json_encode(["error" => "Method not allowed"]);
    }
}

function handleStaff($method, $pdo, $id) {
    switch ($method) {
        case 'GET':
            $stmt = $id ? $pdo->prepare("SELECT * FROM Staff WHERE id = ?") : $pdo->query("SELECT * FROM Staff");
            $stmt->execute($id ? [$id] : []);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $stmt = $pdo->prepare("INSERT INTO Staff (staff_schedule_id, full_name, date_of_hiring, status, description) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$data['staff_schedule_id'], $data['full_name'], $data['date_of_hiring'], $data['status'], $data['description']]);
            echo json_encode(["success" => true, "id" => $pdo->lastInsertId()]);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            $stmt = $pdo->prepare("UPDATE Staff SET staff_schedule_id = ?, full_name = ?, date_of_hiring = ?, status = ?, description = ? WHERE id = ?");
            $stmt->execute([$data['staff_schedule_id'], $data['full_name'], $data['date_of_hiring'], $data['status'], $data['description'], $id]);
            echo json_encode(["success" => true]);
            break;
        case 'DELETE':
            $stmt = $pdo->prepare("DELETE FROM Staff WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(["success" => true]);
            break;
        default:
            echo json_encode(["error" => "Method not allowed"]);
    }
}

function handleSchedule($method, $pdo, $id) {
    switch ($method) {
        case 'GET':
            $stmt = $id ? $pdo->prepare("SELECT * FROM Schedule WHERE id = ?") : $pdo->query("SELECT * FROM Schedule");
            $stmt->execute($id ? [$id] : []);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $stmt = $pdo->prepare("INSERT INTO Schedule (staff_id, coffee_shop_id, date, shift_start, shift_end, revenue, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$data['staff_id'], $data['coffee_shop_id'], $data['date'], $data['shift_start'], $data['shift_end'], $data['revenue'], $data['description']]);
            echo json_encode(["success" => true, "id" => $pdo->lastInsertId()]);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            $stmt = $pdo->prepare("UPDATE Schedule SET staff_id = ?, coffee_shop_id = ?, date = ?, shift_start = ?, shift_end = ?, revenue = ?, description = ? WHERE id = ?");
            $stmt->execute([$data['staff_id'], $data['coffee_shop_id'], $data['date'], $data['shift_start'], $data['shift_end'], $data['revenue'], $data['description'], $id]);
            echo json_encode(["success" => true]);
            break;
        case 'DELETE':
            $stmt = $pdo->prepare("DELETE FROM Schedule WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(["success" => true]);
            break;
        default:
            echo json_encode(["error" => "Method not allowed"]);
    }
}
?>
