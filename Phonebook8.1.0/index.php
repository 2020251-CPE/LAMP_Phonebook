<?php

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';

switch ($request) {
    case '':
    case '/':
    case '/index.php':
        require __DIR__ . $viewDir . 'home.php';
        break;
        
    case '/phonebook':
        require __DIR__ . $viewDir . 'bookphone.php';
        break;
    case '/login':
        require __DIR__ . $viewDir . 'login.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
?>