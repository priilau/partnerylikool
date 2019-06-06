<?php

namespace app\components;

class ActiveForm {
    public $elementType = "input";
    public $inputType = "text";
    public $fieldName = "";
    public $modelName = "";
    public $inputValue = "";
    public $labelStatus = true;
    public $options = [];

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
            $formStr .= "action='{$action}' ";
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
        $str = "<div class='form-group field-{$this->modelName}-{$this->fieldName}'>";
  
        $labelName = str_replace("_", " ", $this->fieldName);
        $labelName = ucfirst($labelName);

        $str .= "<label class='control-label' for='{$this->modelName}-{$this->fieldName}'>{$labelName}</label>";

        if($this->elementType == "input"){
            $str .= "<{$this->elementType} id='{$this->modelName}-{$this->fieldName}' type='{$this->inputType}' name='{$this->fieldName}' value='{$this->inputValue}'>";
        }
        else if($this->elementType == "select"){
            $str .= "<{$this->elementType} id='{$this->modelName}-{$this->fieldName}' name='{$this->fieldName}' value='{$this->inputValue}'>";
            foreach ($this->options as $optionValue => $optionName){
                $optionName = ucfirst($optionName);
                $str .= "<option value='{$optionValue}'>{$optionName}</option>";
            }
            $str .= "</select>";
        }

        $str .= "</div>";
        return $str;
    }
    
    public function label($labelVal){
        $labelVal = $this->labelStatus;
        return $this;
    }
    
    public function field($model, $fieldName, $options = []){
        $this->elementType = "input";
        $this->modelName = strtolower((new \ReflectionClass($model))->getShortName());
        $this->fieldName = strtolower($fieldName);
        $this->inputValue = $model->$fieldName;
        return $this;
    }
    
    public function dropDownList($options){
        $this->elementType = "select";
        $this->options = $options;
        return $this;
    }
    
    public function checkBox(){
        $this->inputType = "checkbox";
        return $this;
    }
}
?>