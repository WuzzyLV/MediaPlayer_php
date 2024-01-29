<?php
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

$nextSongID = $playlistManager->getNextSong($playlistID, $songId)['song_id'];

$nextSong = $songManager->getSong($nextSongID);

if (file_exists($nextSong['path'])){
    header("Content-Transfer-Encoding: binary");
    header("Content-Type: audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3");
    header('Content-Disposition:: inline; filename="'.'song.mp3');
    header('Content-length: ' . filesize($nextSong['path']));
    header('Cache-Control: no-cache');
    header('Accept-Ranges: bytes');
    readfile($nextSong['path']);
}else{
    echo "File not found";
    exit;
}




