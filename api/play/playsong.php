<?php

if (!$_SESSION['loggedIn']) {
    http_response_code(401);
    exit;
}

use Wuzzy\MusicPlayer\SongManager\SongManager;
use Wuzzy\MusicPlayer\Database\User;
use Wuzzy\MusicPlayer\Database\UserData;

$user = new User();
$userId = $user->getIDByUsername($_SESSION['username']);
$userData = new UserData($userId);
$songManager = new SongManager();

$songId = $userData->getCurrentSongId();

if ($songId == null) {
    http_response_code(404);
    exit;
}

$song = $songManager->getSong($songId, $userId);

if ($song == null) {
    http_response_code(404);
    exit;
}


if (file_exists($song['path'])){
    header("Content-Transfer-Encoding: binary");
    header("Content-Type: audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3");
    header('Content-Disposition:: inline; filename="'.'song.mp3');
    header('Content-length: '.filesize($song['path']));
    header('Cache-Control: no-cache');
    header('Accept-Ranges: bytes');
    readfile($song['path']);
}else{
    http_response_code();
    exit;
}

