<?php
if (!$_SESSION['loggedIn']) {
    http_response_code(401);
    exit;
}

use Wuzzy\MusicPlayer\Playlist\PlaylistManager;
use Wuzzy\MusicPlayer\Database\User;
use Wuzzy\MusicPlayer\Database\UserData;

$playlistID = $_POST['id'];
if ($playlistID == null) {
    http_response_code(400);
    exit;
}

$user = new User();
$userId = $user->getIDByUsername($_SESSION['username']);
$userData = new UserData($userId);
$playlistManager = new PlaylistManager();

$userData->setCurrentPlaylistId($playlistID);

$playlist = $playlistManager->getPlaylist($playlistID, $userId);

if ($playlist == null) {
    http_response_code(404);
    exit;
}

$songId = $playlist['songs'][0]['song_id'];

$userData->setCurrentSongId($songId);


//redirect to playsong.php
http_response_code(200);

