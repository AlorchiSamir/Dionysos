<?php

namespace App\Models\Tools;

class Message{

    public static $_instance;

    const TYPE_SUCCESS = 1;
    const TYPE_INFO = 2;
    const TYPE_ERROR = 3;
    const TYPE_WARNING = 4;    

    public function __construct(){
        if(!isset($_SESSION)){
            session_start();
        }
        
    }

    public static function getInstance(){

        if(is_null(self::$_instance)){
            self::$_instance = new Message();
        }
        return self::$_instance;
    }

    public function add($message, $type){
        $_SESSION['messages'][$type][] = $message;
    }

    public function fetch(){

        return (isset($_SESSION['messages'])) ? $_SESSION['messages'] : null;
    }

    public function clean(){       
        unset($_SESSION['messages']); 
    }

}

?>