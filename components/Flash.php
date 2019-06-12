<?php

namespace app\components;

class Flash {
    public $messages = [];

    public function get(){
        if(!isset($_SESSION["FLASH_OBJ"])) {
            $_SESSION["FLASH_OBJ"] = new Flash();
        }
	    return $_SESSION["FLASH_OBJ"];
    }
    
    public function setMessage($index, $message) {
        $flash = self::get();
        $flash->messages[$index] = $message;
    }

    public function removeMessage($index) {
        $flash = self::get();
        if($flash->messages[$index]){
            unset($flash->messages[$index]);
        }
    }
    
    public function getMessage($index) {
        $flash = self::get();
        if($flash->hasMessage($index)) {
            return $flash->messages[$index];
        }
    }
    
    public function hasMessage($index) {
        $flash = self::get();
        return (isset($flash->messages[$index]) && strlen($flash->messages[$index]) > 0); 
    }
    
    public function getMessages() {
        $flash = self::get();
        return $flash->messages;
    }
    
    public function unsetMessages() {
        $flash = self::get();
        $flash->messages = [];
    }
}
?>