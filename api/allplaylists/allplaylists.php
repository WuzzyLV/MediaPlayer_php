<?php
if (!$_SESSION['loggedIn']) {
    http_response_code(401);
    exit;
}

use Wuzzy\MusicPlayer\Playlist\PlaylistManager;
use Wuzzy\MusicPlayer\Database\User;

$user = new User();
$playlistManager = new PlaylistManager();

$playlists = $playlistManager->getAllPlaylists(
    $user->getIDByUsername($_SESSION['username'])
);

//remove serverside info
foreach ($playlists as $key => $playlist) {
    unset($playlists[$key]['user_id']);
}

header('Content-Type: application/json');
echo json_encode($playlists, JSON_PRETTY_PRINT);

