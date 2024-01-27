<?php

if (!$_SESSION['loggedIn']) {
    http_response_code(401);
    exit;
}

use Wuzzy\MusicPlayer\SongManager\SongManager;
use Wuzzy\MusicPlayer\Playlist\PlaylistManager;
use Wuzzy\MusicPlayer\Database\User;
use Wuzzy\MusicPlayer\Database\UserData;

$user = new User();
$userId = $user->getIDByUsername($_SESSION['username']);
$userData = new UserData($userId);
$songManager = new SongManager();
$playlistManager = new PlaylistManager();

$playlistID = $userData->getCurrentPlaylistId();
$songId = $userData->getCurrentSongId();

$nextSongID = $playlistManager->getNextSong($playlistID, $songId)["song_id"];


$userData->setLastPlayedSong($songId);
$userData->setCurrentSongId($nextSongID);

header('Content-Type: application/json');
echo json_encode(array("song" => $nextSongID), JSON_PRETTY_PRINT);



