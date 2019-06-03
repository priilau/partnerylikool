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
        
        if(isset($data["buttons"]) && $data["buttons"] == false){
            $buttons = [];
        }
        if(isset($data["buttons"]) && count($data["buttons"]) > 0){
            $buttons = $data["buttons"];
        }

        $str = "<table class='grid-view'><tr>";
        foreach($attributes as $atr){
            $str .= "<th>". $atr. "</th>"; 
        }
        $str .= "<th></th>";
        $str .= "</tr>";
        foreach($models as $model){
            var_dump($model);
            $str .= "<tr>";
            foreach($attributes as $atr){
                $str .= "<td>". $model->$atr. "</td>"; 
            }
            $str .= "<td>";
            foreach($buttons as $btn){
                $btnName = ucfirst($btn);
                switch($btn){
                    case "view":case "update":case "delete":{
                        $str .= "<a href='/{$controller}/{$btn}?id={$model->id}'>{$btnName}</a> ";
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