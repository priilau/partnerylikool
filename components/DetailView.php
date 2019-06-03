<?php 

namespace app\components;

class DetailView {
    public static function widget($data){
        if(!isset($data["model"])){
            return "Model not set!";
        }
        if(!isset($data["attributes"])){
            return "Attributes not set!";
        }
        $model = $data["model"];
        $attributes = $data["attributes"];
        $str = "<table class='detail-view'>";
        foreach($attributes as $atr){
            $str .= "<tr><td>". $atr. "</td>"; 
            $str .= "<td>". $model->$atr. "</td></tr>"; 
        }
        $str .= "</table>";
        return $str;
    }
}
?>