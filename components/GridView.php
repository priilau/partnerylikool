<?php 

namespace app\components;


class GridView {
    public static function widget($data){
        if(!isset($data["models"])){
            return "Models not set!";
        }
        if(!isset($data["columns"])){
            return "Columns not set!";
        }
        
        $models = $data["models"];
        $attributes = $data["columns"];
        $buttons = ["view", "update", "delete"];
        $controller = Request::getController();
        $labels = [];

        if(count($models) > 0) {
            $firstModel = reset($models);
            $labels = $firstModel->attributeLabels();
        }
        
        if(isset($data["buttons"]) && $data["buttons"] == false){
            $buttons = [];
        }
        if(isset($data["buttons"]) && count($data["buttons"]) > 0){
            $buttons = $data["buttons"];
        }

        $str = "<table class='grid-view'><tr>";

        foreach($attributes as $atr){
            if(is_array($atr)) {
                $label = "";
                if(isset($atr["label"])) {
                    $label = $atr["label"];
                } else {
                    $label = $atr["attribute"];
                    if(isset($labels[$label])) {
                        $label = $labels[$label];
                    }
                }

                $str .= "<th>{$label}</th>";
            } else {
                $label = $atr;
                if(isset($labels[$atr])) {
                    $label = $labels[$atr];
                }
                $str .= "<th>{$label}</th>";
            }
        }

        $str .= "<th></th>";
        $str .= "</tr>";

        foreach($models as $m){
            $str .= "<tr>";
            foreach($attributes as $atr) {
                if(is_array($atr)) {
                    $columnValue = $atr["value"]($m);
                    $str .= "<td>{$columnValue}</td>";
                } else {
                    $val = $m->$atr;
                    $str .= "<td>{$val}</td>";
                }
            }
            $str .= "<td>";
            foreach($buttons as $btn){
                $btnName = ucfirst($btn);
                switch($btn){
                    case "view":case "update":case "delete":{
                        $str .= "<a href='/{$controller}/{$btn}?id={$m->id}'>{$btnName}</a> ";
                        break;
                    }
                }
            }
            $str .= "</td>";
            $str .= "</tr>";
        }
        $str .= "</table>";
        return $str;
    }
}
?>