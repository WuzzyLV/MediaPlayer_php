<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

$requestUri = $_SERVER['REQUEST_URI'];

//remove get parameter
$requestUri = explode('?', $requestUri)[0];

session_start();
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
        $_SESSION['username'] = null;
        header('Location: /login');
        break;
    case '/upload':
        require "../views/upload/upload.php";
        break;
    case '/api/allsongs':
        require "../api/allsongs/allsongs.php";
        break;
    case '/api/newplaylist':
        require "../api/newplaylist/newplaylist.php";
        break;
    case '/api/allplaylists':
        require "../api/allplaylists/allplaylists.php";
        break;
    default:
        require "../views/index/index.php";
        break;
}