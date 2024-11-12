<?php
session_start();

require 'database.php';
$pdo = connectDatabase();
header("Content-Type: application/json");

$action = $_POST['action'] ?? $_GET['action'] ?? null;

switch ($action) {
    case 'login':
        loginUser();
        break;

    case 'logout':
        logoutUser();
        break;

    case 'check_auth':
        checkAuth();
        break;

    case 'get_user_info':
        getUserInfo();
        break;
    
    case 'get_user_info':
        getUserInfo();
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}

// Функция для авторизации пользователя
function loginUser() {
    global $pdo;

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, username, password_hash FROM Users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
    }
}


// Функция для завершения сессии
function logoutUser() {
    session_unset();
    session_destroy();
    echo json_encode(['status' => 'success']);
}

// Функция для проверки авторизации
function checkAuth() {
    if (isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
    }
}
// Функция для вывода названия пользователя



function getUserInfo() {
    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
        echo json_encode(['status' => 'success', 'username' => $_SESSION['username']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
    }
}


?>
