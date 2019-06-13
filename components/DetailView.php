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
        $labels = $model->attributeLabels();

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

                $val = $atr["value"]($model);
                $str .= "<tr><td>{$label}</td>";
                $str .= "<td>{$val}</td></tr>";
            } else {
                $label = $atr;

                if(isset($labels[$atr])) {
                    $label = $labels[$atr];
                }

                $val = $model->$atr;
                $label = str_ireplace("_", " ", $label);
                $str .= "<tr><td>{$label}</td>";
                $str .= "<td>{$val}</td></tr>";
            }
        }

        $str .= "</table>";
        return $str;
    }
}
?>