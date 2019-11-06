<?php

namespace app\components;

use app\config\App;

class ActiveForm {
    public $elementType = "input";
    public $inputType = "text";
    public $fieldName = "";
    public $modelName = "";
    public $inputValue = "";
    public $optionValAsDataVal = false;
    public $labelStatus = true;
    public $options = [];
    public $model = null;

    public static function begin($method = "POST", $enctype = null, $action = null){
        $activeForm = new ActiveForm();
        $formStr = "<form ";
        if($method != null){
            $formStr .= "method='{$method}' "; 
        }
        if($enctype != null){
            $formStr .= "enctype='{$enctype}' ";
        }
        if($action != null){
            $urlTo = Url::to($action);
            $formStr .= "action='$urlTo' ";
        }
        $formStr = rtrim($formStr, " ");
        $formStr .= ">";
        echo $formStr;
        return $activeForm;
    }

    public static function end(){
        echo "</form>";
    }

    public static function submitButton($btnText, $options){
        $str = "<input type='submit' value='{$btnText}' ";
        foreach($options as $optionName => $optionValue){
            $str .= "{$optionName}='{$optionValue}' ";
        }
        $str = rtrim($str, " ");
        $str .= ">";
        return $str;
    }

    public function __toString(){
        $lowerFieldName = strtolower($this->fieldName);
        $str = "<div class='form-group field-{$this->modelName}-{$lowerFieldName}'>";

        $labels = $this->model->attributeLabels();
        $labelName = $this->fieldName;

        if(isset($labels[$this->fieldName])) {
            $labelName = $labels[$this->fieldName];
        } else {
            $labelName = str_replace("_", " ", $this->fieldName);
            $labelName = ucfirst($labelName);
        }

        $str .= "<label class='control-label' for='{$this->modelName}-{$lowerFieldName}'>{$labelName}</label>";
        $fName = $this->fieldName;

        if($this->elementType == "input" || $this->elementType == "textarea"){
            $value = "";
            $checked = "";
            if($this->inputType == "checkbox") {
                $checked = ($this->model->$fName) ? 'checked' : '';
            } else {
                $value = "value='{$this->inputValue}'";
            }
            $str .= "<{$this->elementType} id='{$this->modelName}-{$lowerFieldName}' type='{$this->inputType}' name='{$this->fieldName}' {$value} {$checked}>";
            if($this->elementType == "textarea") {
                $str .= "{$this->inputValue}</{$this->elementType}>";
            }
        }
        else if($this->elementType == "select"){
            $str .= "<{$this->elementType} id='{$this->modelName}-{$lowerFieldName}' name='{$this->fieldName}' value='{$this->inputValue}'>";
            foreach ($this->options as $optionValue => $optionName){
                $optionName = ucfirst($optionName);
                $selected = (($this->model->$fName == $optionName && $this->optionValAsDataVal) || ($this->model->$fName == $optionValue && !$this->optionValAsDataVal)) ? 'selected="selected"' : '';

                if($this->optionValAsDataVal) {
                    $str .= "<option value='{$optionName}' {$selected}>{$optionName}</option>";
                } else {
                    $str .= "<option value='{$optionValue}' {$selected}>{$optionName}</option>";
                }
            }
            $str .= "</select>";
        }

        $str .= "</div>";
        return $str;
    }
    
    public function label($labelVal){
        $this->labelStatus = $labelVal;
        return $this;
    }
    
    public function field($model, $fieldName){
        $this->elementType = "input";
        $this->inputType = "text";
        $this->modelName = Helper::getClassName($model);
        $this->fieldName = $fieldName;
        $this->inputValue = $model->$fieldName;
        $this->model = $model;
        return $this;
    }
    
    public function password(){
        $this->inputType = "password";
        return $this;
    }

    public function dropDownList($options, $optionValAsDataVal = false){
        $this->elementType = "select";
        $this->options = $options;
        $this->optionValAsDataVal = $optionValAsDataVal;
        return $this;
    }

    public function checkBox(){
        $this->inputType = "checkbox";
        return $this;
    }

    public function textarea(){
        $this->elementType = "textarea";
        return $this;
    }
}
?>