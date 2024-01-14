<?php
if (!$_SESSION['loggedIn']) {
    http_response_code(401);
    exit;
}

use Wuzzy\MusicPlayer\Playlist\PlaylistManager;
use Wuzzy\MusicPlayer\Database\User;

$user = new User();
$playlistManager = new PlaylistManager();

$playlistID = $playlistManager->createPlaylist(
    $user->getIDByUsername($_SESSION['username']),
    $_POST['name'],
    $_POST['songs']
);

header('Content-Type: application/json');
echo json_encode(["playlistID"=>$playlistID], JSON_PRETTY_PRINT);



