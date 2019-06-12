<?php
namespace app\models;

use app\components\QueryBuilder;
use app\components\Helper;
use app\components\Flash;
	
class BaseModel {
	public $attributes = [];
	public $errors = [];
	public $rules = [];

	public function getSaveQuery(){
		if(isset($this->attributes["id"]) && $this->attributes["id"] > 0){
			return \app\components\QueryBuilder::update(static::tableName(), $this->attributes, ["=", "id", $this->attributes["id"]])->compose();
		}
		return \app\components\QueryBuilder::insert(static::tableName(), $this->attributes)->compose();
	}

    public function attributeLabels() {
        return [];
    }
	
	public function __get($key)
    {
		if(!isset($this->attributes[$key])){
			return null;
		}
        return $this->attributes[$key];
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }
	
	public function addError($message){
		$errors[] = $message;
		Flash::setMessage("error", $message);
	}
	
	public function showErrorsAsHtml(){
		$html = "";
		foreach ($this->errors as $key => $error){
			$html .= "{($key + 1)}{$error}<br>";
		}
		return $html;
	}
	
	public function save(){
		if($this->validate()){
		    $this->beforeSave();

			if(isset($this->attributes["id"]) && $this->attributes["id"] > 0){
				QueryBuilder::update(static::tableName(), $this->attributes, ["=","id", $this->attributes["id"]])->execute();
			} else {
				$this->attributes["id"] = QueryBuilder::insert(static::tableName(), $this->attributes)->execute();
				if ($this->attributes["id"] == 0){
					$this->addError("Model save insert failed!");
					return false;
				}
			}
			return true;
		}
		return false;
	}

	public function beforeSave() {
        $this->rules = $this->rules();

        foreach ($this->rules as $value) {
            if(is_array($value)){

                switch ($value[1][0]) {
                    case "auto-hash-128": {
                        $this->setValueToAllRuleFields($value[0], Helper::generateRandomString());
                        break;
                    }
                    case "created-datetime":{
                        $this->setValueToAllRuleFields($value[0], (new DateTime('now'))->format('Y-m-d H:i:s'));
                        break;
                    }
                    case "updated-datetime":{
                        $this->setValueToAllRuleFields($value[0], (new DateTime('now'))->format('Y-m-d H:i:s'), true);
                        break;
                    }
                }
            }
        }
	}

	public function setValueToAllRuleFields($fields, $value, $byPassEmpty = false) {
        foreach ($fields as $fieldName){
            $fieldValue = $this->$fieldName;
            if($byPassEmpty || ($fieldValue == null || $fieldValue == "" || !isset($fieldValue))) {
                $this->$fieldName = $value;
            }
        }
    }
	
	public function validate(){
		$errors = [];
		$this->rules = $this->rules();
		foreach ($this->attributes as $key => $fieldValue){
			$ruleFound = false;
			
			foreach ($this->rules as $value){
				if(is_array($value)){
					foreach ($value[0] as $fieldName){
						if($fieldName == $key){
							$ruleFound = true;
							foreach ($value[1] as $dataRule){
								switch($dataRule){
									case "string":{
										if(!is_string($fieldValue)){
											$this->addError("{$fieldName} - Must be a string!");
										}
										break;
									}
									case "integer":{
										if(!is_int($fieldValue)){
											$this->addError("{$fieldName} - Must be an integer!");
										}
										break;
									}
									case "double":{
										if(!is_double($fieldValue)){
											$this->addError("{$fieldName} - Must be a double!");
										}
										break;
									}
									case "float":{
										if(!is_float($fieldValue)){
											$this->addError("{$fieldName} - Must be a float!");
										}
										break;
									}
									case "email":{
										if(!$this->validateEmail($fieldValue)){
											$this->addError("{$fieldName} - Email is not valid!");
										}
										break;
									}
								}
							}
						} 
					}
				}
			}
			
			if (!$ruleFound){
				$this->addError("{$fieldName} - Rule not found!");
			}
		}
		return !(count($errors));
	}
	
	public function load($post){
		if(isset($post) && is_array($post) && count($post)){
			foreach ($post as $key => $value) {
				$this->attributes[$key] = $value;
				$this->$key = $value;
			}
			return true;
		}
		return false;
	}
	
	public function delete(){
		QueryBuilder::delete(static::tableName(), ["=", "id", $this->id])->execute();
	}

	public function validateEmail($email){
		$splitEmail = explode("@", $email);
		$splitDomain = explode(".", $splitEmail[1]);

		if(!Helper::isStringClean($splitEmail[0]) || !Helper::isStringClean($splitDomain[0]) || !Helper::isStringClean($splitDomain[1])){
			return false;
		} else {
			return true;
		}
	}
}

?>