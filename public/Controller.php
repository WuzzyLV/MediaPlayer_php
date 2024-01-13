<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

$requestUri = $_SERVER['REQUEST_URI'];

//remove get parameter
$requestUri = explode('?', $requestUri)[0];

session_start();
echo $_SESSION['loggedIn'];
//init value if not set
if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = false;
}

if ($_SESSION['loggedIn'] == false && $requestUri != '/login') {
    if ($requestUri != '/login') {
        header('Location: /login');
        exit;
    }
} else if ($_SESSION['loggedIn'] && $requestUri == '/login') {
    header('Location: /');
    exit;
}

switch ($requestUri) {
    case '/login':
        require "../views/login/login.php";
        break;
    case '/logout':
        $_SESSION['loggedIn'] = false;
        header('Location: /login');
        break;
    default:
        echo "lel";
        break;
}