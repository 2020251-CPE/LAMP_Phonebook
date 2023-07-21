<?php

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';

switch ($request) {
    case '':
    case '/':
    case '/index.php':
    case '/views/home.php':
        require __DIR__ . $viewDir . 'home.php';
        break;
    case '/views/bookphone.php':
    case '/phonebook':
        require __DIR__ . $viewDir . 'bookphone.php';
        break;
    case '/views/login.php':
    case '/login':
        require __DIR__ . $viewDir . 'login.php';
        break;
    case '':
    case '/register':
        require __DIR__ . $viewDir . 'register.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
?>