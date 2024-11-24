<?php

header("Content-Type: application/json");

require 'database.php';


// Получаем метод запроса и параметры
$requestMethod = $_SERVER['REQUEST_METHOD'];
$entity = isset($_GET['entity']) ? $_GET['entity'] : null;
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

// Подключаемся к базе данных
$pdo = connectDatabase();


switch ($entity) {
    
// Проверяем сущность и выполняем нужные CRUD-операции
    case 'staff_schedule':
        handleStaffSchedule($requestMethod, $pdo, $id);
        break;
    case 'staff':
        handleStaff($requestMethod, $pdo, $id);
        break;
    case 'schedule':
        handleSchedule($requestMethod, $pdo, $id);
        break;
    case 'coffee_shop':  // Новый блок для работы с CoffeeShop
        handleCoffeeShop($requestMethod, $pdo, $id);
        break;

    case 'projects':
        handleProjects($method, $pdo, $id);
        break;
    case 'tasks':
        handleTasks($method, $pdo, $id);
        break;

    default:
        echo json_encode(["error" => "Invalid entity specified"]);
}

// CRUD для StaffSchedule
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

// CRUD для Staff
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

// CRUD для Schedule
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

// CRUD для CoffeeShop
function handleCoffeeShop($method, $pdo, $id) {
    switch ($method) {
        case 'GET':
            $stmt = $id ? $pdo->prepare("SELECT * FROM CoffeeShop WHERE id = ?") : $pdo->query("SELECT * FROM CoffeeShop");
            $stmt->execute($id ? [$id] : []);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $stmt = $pdo->prepare("INSERT INTO CoffeeShop (name, address, description) VALUES (?, ?, ?)");
            $stmt->execute([$data['name'], $data['address'], $data['description']]);
            echo json_encode(["success" => true, "id" => $pdo->lastInsertId()]);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            $stmt = $pdo->prepare("UPDATE CoffeeShop SET name = ?, address = ?, description = ? WHERE id = ?");
            $stmt->execute([$data['name'], $data['address'], $data['description'], $id]);
            echo json_encode(["success" => true]);
            break;
        case 'DELETE':
            $stmt = $pdo->prepare("DELETE FROM CoffeeShop WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(["success" => true]);
            break;
        default:
            echo json_encode(["error" => "Method not allowed"]);
    }
}

// Функция для обработки запросов к таблице Projects
function handleProjects($method, $pdo, $id) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Projects WHERE id = ?");
                $stmt->execute([$id]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("SELECT * FROM Projects");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $stmt = $pdo->prepare("INSERT INTO Projects (name, description, start_date, end_date, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$data['name'], $data['description'], $data['start_date'], $data['end_date'], $data['status']]);
            echo json_encode(['id' => $pdo->lastInsertId()]);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            $stmt = $pdo->prepare("UPDATE Projects SET name = ?, description = ?, start_date = ?, end_date = ?, status = ? WHERE id = ?");
            $stmt->execute([$data['name'], $data['description'], $data['start_date'], $data['end_date'], $data['status'], $id]);
            echo json_encode(['status' => 'success']);
            break;
        case 'DELETE':
            $stmt = $pdo->prepare("DELETE FROM Projects WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['status' => 'success']);
            break;
    }
}

// Функция для обработки запросов к таблице Tasks
function handleTasks($method, $pdo, $id) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Tasks WHERE id = ?");
                $stmt->execute([$id]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("SELECT * FROM Tasks");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $stmt = $pdo->prepare("INSERT INTO Tasks (project_id, staff_id, title, description, start_date, due_date, status, priority) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$data['project_id'], $data['staff_id'], $data['title'], $data['description'], $data['start_date'], $data['due_date'], $data['status'], $data['priority']]);
            echo json_encode(['id' => $pdo->lastInsertId()]);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            $stmt = $pdo->prepare("UPDATE Tasks SET project_id = ?, staff_id = ?, title = ?, description = ?, start_date = ?, due_date = ?, status = ?, priority = ? WHERE id = ?");
            $stmt->execute([$data['project_id'], $data['staff_id'], $data['title'], $data['description'], $data['start_date'], $data['due_date'], $data['status'], $data['priority'], $id]);
            echo json_encode(['status' => 'success']);
            break;
        case 'DELETE':
            $stmt = $pdo->prepare("DELETE FROM Tasks WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['status' => 'success']);
            break;
    }
}

?>
