<?php

namespace Wuzzy\MusicPlayer\Database;
use Wuzzy\MusicPlayer\Database\Connection;

class UserData
{
    private \mysqli $connection;
    private int $userID;
    public function __construct($userID)
    {
        $database = new Connection();
        $this->connection = $database->getConnection();
        $this->userID = $userID;

        $this->initUserData();
    }

    private function initUserData(): void
    {
        $query = "SELECT * FROM user_data WHERE user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $this->userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        if ($userData != null) {
            return;
        }

        $query = "INSERT INTO user_data (user_id) VALUES (?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $this->userID);
        $stmt->execute();
    }

    public function getUserData(): array
    {
        $query = "SELECT * FROM user_data WHERE user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $this->userID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function setLastPlayedSong($songID): void
    {
        $query = "UPDATE user_data SET last_played_song_id = ? WHERE user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ii", $songID, $this->userID);
        $stmt->execute();
    }
    public function getLastPlayedSong(): int
    {
        return $this->getUserData()['last_played_song'];
    }

    public function setCurrentSongId($songID): void
    {
        $query = "UPDATE user_data SET current_song_id = ? WHERE user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ii", $songID, $this->userID);
        $stmt->execute();
    }

    public function getCurrentSongId(): int
    {
        return $this->getUserData()['current_song_id'];
    }


    public function setCurrentPlaylistId($playlistID): void
    {
        $query = "UPDATE user_data SET current_playlist_id = ? WHERE user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ii", $playlistID, $this->userID);
        $stmt->execute();
    }

    public function getCurrentPlaylistId(): int
    {
        return $this->getUserData()['current_playlist_id'];
    }


}