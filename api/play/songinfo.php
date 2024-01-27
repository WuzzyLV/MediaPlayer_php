<?php
use Wuzzy\MusicPlayer\SongManager\SongManager;
use Wuzzy\MusicPlayer\Playlist\PlaylistManager;
use Wuzzy\MusicPlayer\Database\User;
use Wuzzy\MusicPlayer\Database\UserData;

$user = new User();
$userId = $user->getIDByUsername($_SESSION['username']);
$userData = new UserData($userId);
$songManager = new SongManager();

$currentSongID = $userData->getCurrentSongId();

$song = $songManager->getSong($currentSongID);

if ($song == null) {
    http_response_code(404);
    exit;
}

unset($song["id"]);
unset($song["user_id"]);
unset($song["path"]);

header('Content-Type: application/json');
echo json_encode($song, JSON_PRETTY_PRINT);