<?php

namespace app\components;

class Alert {
    public static function showMessages(){
        $str = "<div class='alerts'>";
        foreach(Flash::getMessages() as $key => $error){
            $label = ucfirst($key);
            $msg = ucfirst($error);
            $str .= "<div class='alert alert-{$key}'>";
            $str .= "<strong>{$label}!</strong> {$msg}.";
            $str .= "</div>";
        }
        $str .= "</div>";
        Flash::unsetMessages();
        return $str;
    }
}
?>