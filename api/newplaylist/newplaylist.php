<?php
if (!$_SESSION['loggedIn']) {
    http_response_code(401);
    exit;
}

use Wuzzy\MusicPlayer\Playlist\PlaylistManager;
use Wuzzy\MusicPlayer\Database\User;

$user = new User();
$playlistManager = new PlaylistManager();

if (!isset($_POST['name']) || !isset($_POST['songs'])) {
    http_response_code(400);
    exit;
}


$playlistID = $playlistManager->createPlaylist(
    $user->getIDByUsername($_SESSION['username']),
    $_POST['name'],
    $_POST['songs']
);

header('Content-Type: application/json');
echo json_encode(["playlistID"=>$playlistID], JSON_PRETTY_PRINT);



