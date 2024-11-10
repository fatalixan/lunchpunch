<?php
session_start();

require 'database.php';

header("Content-Type: application/json");

$action = $_POST['action'] ?? $_GET['action'] ?? null;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pdo = connectDatabase();

switch ($action) {
    case 'login':
        loginUser();
        break;

    case 'logout':
        logoutUser();
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}

function loginUser() {

    global $pdo;

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, password_hash FROM Users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
    }
}

function logoutUser() {
    session_unset();
    session_destroy();
    echo json_encode(['status' => 'success']);
}
?>
