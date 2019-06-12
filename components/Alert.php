<?php

namespace app\components;

class Alert {
    public static function showMessages(){
        $str = "<div class='alerts'>";
        foreach(Flash::getMessages() as $key => $error){
            $str .= "<div class='alert alert-{$key}'>";
            $label = ucfirst($key);
            $msg = ucfirst($error);
            $str .= "<strong>{$label}!</strong> {$msg}.";
            $str .= "</div>";
        }
        $str .= "</div>";
        Flash::unsetMessages();
        return $str;
    }
}
?>