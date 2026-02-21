<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\TaskController;

$taskController = new TaskController();

$route = $_GET['route'] ?? 'home';

$authController = new AuthController();

switch ($route) {

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register();
        } else {
            $authController->showRegisterForm();
        }
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            $authController->showLoginForm();
        }
        echo '<a href="?route=register">Register</a> | ';
        break;

    case 'dashboard':
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?route=login");
            exit;
        }

        echo "<h2>Dashboard</h2>";
        echo "<p>You are logged in!</p>";
        echo '<a href="?route=tasks">View Tasks</a><br>';
        echo '<a href="?route=logout">Logout</a>';
        
        break;

    case 'logout':
        $authController->logout();
        break;

    default:
        echo '<h1>Welcome</h1>';
        echo '<a href="?route=register">Register</a> | ';
        echo '<a href="?route=login">Login</a>';
        break;
        case 'tasks':
    if (!isset($_SESSION['user_id'])) {
        header("Location: ?route=login");
        exit;
    }
    $taskController->index();
    break;

    case 'task.create':
        $taskController->createForm();
        break;

    case 'task.store':
        $taskController->store();
        break;

    case 'task.complete':
        $taskController->complete();
        break;

    case 'task.delete':
        $taskController->delete();
        break;
}