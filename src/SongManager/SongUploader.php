<?php

namespace Wuzzy\MusicPlayer\SongManager;

use Wuzzy\MusicPlayer\Database\Connection;
use Wuzzy\MusicPlayer\Error\Error;
use wapmorgan\Mp3Info\Mp3Info;
use Wuzzy\MusicPlayer\Database\User;

class SongUploader {
    protected $connection;

    public function __construct() {
        $database = new Connection();
        $this->connection = $database->getConnection();
    }

    public function uploadSong($file) {
        $errors = new Error();

        if (!$this->isValidExtension($file)) {
            $errors->addError("Invalid file extension");
            return $errors;
        }
        $file_size = $file['size'];

        if($file_size > 20971520){
            $errors[]='File size must be less than 20 MB';
            return $errors;
        }
        $file_name = $file['name'];

        if(file_exists(SONG_PATH . $file_name)){
            $file_name = $this->getNewFileName($file);
        }

        $file_tmp = $file['tmp_name'];

        $file_path = SONG_PATH . $file_name;
        move_uploaded_file($file_tmp, $file_path);

        $tags = $this->getID3Data($file_path);

        if ($this->isSongInDB($tags)) {
            $errors->addError("Song already exists in database");
            unlink($file_path);
            return $errors;
        }

        if (!$this->addToDatabase($file_path, $tags)) {
            $errors->addError("Error adding song to database");
            return $errors;
        }
    }

    private function isValidExtension($file) {
        $file_name_parts = explode('.', $file['name']);
        $file_ext = strtolower(end($file_name_parts));

        $extensions= array("mp3","wav","ogg");

        return in_array($file_ext,$extensions);
    }

    private function getNewFileName($file){
        $file_name = $file['name'];
        $new_name = $file_name;
        $i = 1;
        while(file_exists(SONG_PATH . $new_name)){
            //seperate extension
            $file_name_parts = explode('.', $file_name);
            $file_ext = strtolower(end($file_name_parts));
            //remove extension
            $new_name = str_replace('.' . $file_ext, '', $file_name);
            $new_name = $new_name . "_(" . $i . ")." . $file_ext;
            $i++;
        }
        echo $new_name;
        return $new_name;
    }

    private function getID3Data($file_path){
        $audio = new Mp3Info($file_path, true);
        $tags= array();

        $tags['title'] = $audio->tags['song'] ?? '';
        $tags['artist'] = $audio->tags['artist'] ?? '';
        $tags['album'] = $audio->tags['album'] ?? '';
        $tags['year'] = $audio->tags['year'] ?? '';

        return $tags;
    }

    private function isSongInDB($tags) {
    
        $sql = "SELECT * FROM songs WHERE title = ?";
        $stmt = $this->connection->prepare($sql);

        if ($stmt == false) {
            return false;
        }

        $stmt->bind_param('s', $tags['title']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        }

        return false;
    }

    private function addToDatabase($path, $tags) {
        $user = new User();

        $userID = $user->getIDByUsername($_SESSION['username']);

        if ($userID == null) {
            return false;
        }

        $sql = "INSERT INTO songs (path, title, artist, album, year, user_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);

        if ($stmt == false) {
            return false;
        }

        $stmt->bind_param('sssssi', $path, $tags['title'], $tags['artist'], $tags['album'], $tags['year'], $userID);
        $stmt->execute();
        return true;
    }
}