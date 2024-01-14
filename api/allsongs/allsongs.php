<?php 
if (!$_SESSION['loggedIn']) {
    http_response_code(401);
    exit;
}

use Wuzzy\MusicPlayer\SongManager\SongManager;
use Wuzzy\MusicPlayer\Database\User;

$user = new User();
$songManager = new SongManager();

$songs = $songManager->getAllSongs(
    $user->getIDByUsername($_SESSION['username'])
);
//remove serverside info
foreach ($songs as $key => $song) {
    unset($songs[$key]['user_id']);
    unset($songs[$key]['path']);
}

header('Content-Type: application/json');
echo json_encode($songs, JSON_PRETTY_PRINT);


