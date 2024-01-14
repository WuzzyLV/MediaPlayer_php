<?php

namespace Wuzzy\MusicPlayer\Playlist;

use Wuzzy\MusicPlayer\Database\Connection;
use Wuzzy\MusicPlayer\Database\User;
use Wuzzy\MusicPlayer\Error\Error;

class PlaylistManager {
    protected $connection;

    public function __construct() {
        $database = new Connection();
        $this->connection = $database->getConnection();
    }

    public function getAllPlaylists(int $userID) {
        $query = "SELECT * FROM playlists WHERE user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $playlists = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($playlists as $key => $playlist) {
            $playlists[$key]['songs'] = $this->getPlaylistsSongs($playlist['id']);
        }

        return $playlists;
    }

    public function getPlaylist($playlistID, $userID) {
        $query = "SELECT * FROM playlists WHERE id = ? AND user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ii", $playlistID, $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $playlist = $result->fetch_assoc();

        $playlist['songs'] = $this->getPlaylistsSongs($playlistID);

        return $playlist;
    }

    public function getPlaylistByTitle($userID, $name) {
        $query = "SELECT * FROM playlists WHERE name = ? AND user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("si", $name, $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $playlist = $result->fetch_assoc();

        $playlist['songs'] = $this->getPlaylistsSongs($playlist['id']);

        return $playlist;
    }

    public function createPlaylist($userID, $name, $songs) {
        $query = "INSERT INTO playlists (user_id, name) VALUES (?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("is", $userID, $name);
        $stmt->execute();
        $playlistID = $stmt->insert_id;

        $query = "INSERT INTO playlist_songs (playlist_id, song_id) VALUES (?, ?)";
        $stmt = $this->connection->prepare($query);
        foreach ($songs as $song) {
            $stmt->bind_param("ii", $playlistID, $song);
            $stmt->execute();
        }

        return $playlistID;
    }

    private function getPlaylistsSongs($playlistID) {
        $query = "SELECT songs.id AS song_id, songs.title, songs.artist, songs.album, songs.year FROM songs "
        . "JOIN playlist_songs ON songs.id = playlist_songs.song_id "
        . "JOIN playlists ON playlist_songs.playlist_id = playlists.id WHERE playlists.id = (?);";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $playlistID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


}