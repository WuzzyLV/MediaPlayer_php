<?php

namespace Wuzzy\MusicPlayer\SongManager;

use Wuzzy\MusicPlayer\Database\Connection;
use Wuzzy\MusicPlayer\Database\User;
use Wuzzy\MusicPlayer\Error\Error;

class SongManager {

    protected $connection;

    public function __construct() {
        $database = new Connection();
        $this->connection = $database->getConnection();
    }

    public function getAllSongs(int $userID) {
        $query = "SELECT * FROM songs WHERE user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $songs = $result->fetch_all(MYSQLI_ASSOC);
        return $songs;
    }

    public function getSong($songID) {
        $query = "SELECT * FROM songs WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $songID);
        $stmt->execute();
        $result = $stmt->get_result();
        $song = $result->fetch_assoc();
        return $song;
    }

    public function getSongByTitle($userID, $title) {
        $query = "SELECT * FROM songs WHERE title = ? AND user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("si", $title, $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $song = $result->fetch_assoc();
        return $song;
    }

    public function getSongByArtist($userID, $artist) {
        $query = "SELECT * FROM songs WHERE artist = ? AND user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("si", $artist, $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $song = $result->fetch_assoc();
        return $song;
    }

    public function getSongByAlbum($userID, $album) {
        $query = "SELECT * FROM songs WHERE album = ? AND user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("si", $album, $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $song = $result->fetch_assoc();
        return $song;
    }


}