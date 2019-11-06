<?php
namespace app\components;

use app\config\App;

class Url {
    public static function to($url) {
        if (strpos($url, 'http') !== false) {
            return $url;
        }

        $host = $_SERVER["HTTP_HOST"];
        $url = App::$http.$host.App::$rootDir.$url;

        return $url;
    }

    public static function a($label, $url, $DOMClassName = "", $openInNewTab = false) {
        $url = self::to($url);
        $tab = $openInNewTab ? " target='_blank'" : "";
        return "<a$tab href='$url' class='$DOMClassName'>$label</a>";
    }
}

?>