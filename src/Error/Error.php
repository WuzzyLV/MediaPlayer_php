<?php
namespace Wuzzy\MusicPlayer\Error;

class Error {
    protected $message;

    public function __construct() {
        $this->message = array();
    }

    public function addError($error) {
        $this->message[] = $error;
    }

    public function getErrors() {
        return $this->message;
    }
    public function hasErrors() {
        return count($this->message) > 0;
    }


}