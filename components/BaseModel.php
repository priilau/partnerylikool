<?php
namespace app\models;

use app\components\QueryBuilder;
use app\components\Helper;
use app\components\Flash;
use app\components\Identity;
	
class BaseModel {
	public $attributes = [];
	public $oldAttributes = [];
	public $errors = [];
	public $rules = [];

    public function __toString() {
        $str = "";
        if(isset($this->attributes["name"])) {
			$str = $this->attributes["name"];
        } else if(isset($this->attributes["firstname"]) && isset($this->attributes["lastname"])) {
			$str = $this->attributes["firstname"]." ".$this->attributes["lastname"];
        } else if(isset($this->attributes["firstname"])) {
			$str = $this->attributes["firstname"];
        } else if(isset($this->attributes["lastname"])) {
			$str = $this->attributes["lastname"];
        } else if(isset($this->attributes["email"])) {
			$str = $this->attributes["email"];
        } else if(isset($this->attributes["outcome"])) {
            $str = $this->attributes["outcome"];
        } else {
            $str = Helper::getClassName($this)." ".$this->attributes["id"];
        }
        return $str;
    }

	public function getSaveQuery(){
		if(isset($this->attributes["id"]) && $this->attributes["id"] > 0){
			return QueryBuilder::update(static::tableName(), $this->attributes, ["=", "id", $this->attributes["id"]])->compose();
		}
		return QueryBuilder::insert(static::tableName(), $this->attributes)->compose();
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
		$this->errors[] = $message;
		Flash::setMessage("error", $this->showErrorsAsHtml());
	}
	
	public function showErrorsAsHtml(){
		$html = "";
		foreach ($this->errors as $key => $error){
			$spot = $key + 1;
			$html .= "{$spot} {$error}<br>";
		}
		return $html;
	}
	
	public function save(){
        $this->oldAttributes = $this->attributes;
		$this->beforeValidate();

		if($this->validate()){
		    $this->beforeSave();

			if(isset($this->attributes["id"]) && $this->attributes["id"] > 0){
				QueryBuilder::update(static::tableName(), $this->attributes, ["=","id", $this->attributes["id"]])->execute();
				$this->afterSave();
			} else {
				$this->attributes["id"] = QueryBuilder::insert(static::tableName(), $this->attributes)->execute();
				if ($this->attributes["id"] == 0){
					$this->addError("Model save insert failed!");
                    $this->attributes = $this->oldAttributes;
					return false;
				}
				$this->afterSave();
			}
			return true;
		}
        $this->attributes = $this->oldAttributes;
		return false;
	}

	public function beforeValidate(){
    	$this->rules = $this->rules();
		$this->autoFillFields();
	}
	public function autoFillFields(){
		foreach ($this->rules as $value) {
            if(is_array($value)){
                switch ($value[1][0]) {
                    case "auto-hash-128": {
                        $this->setValueToAllRuleFields($value[0], Helper::generateRandomString());
                        break;
                    }
                    case "created-datetime":{
                        $this->setValueToAllRuleFields($value[0], (new \DateTime('now'))->format('Y-m-d H:i:s'));
                        break;
                    }
                    case "updated-datetime":{
                        $this->setValueToAllRuleFields($value[0], (new \DateTime('now'))->format('Y-m-d H:i:s'), true);
                        break;
					}
					case "auto-user-id":{
						$this->setValueToAllRuleFields($value[0], Identity::getUserId());
						break;
					}
                }
            }
        }
	}

	public function beforeSave() {

	}

	public function afterSave() {
		
	}
	
	public function beforeDelete() {
		
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
										$parsedVal = intval($fieldValue);
										if(!is_int($fieldValue) && (($parsedVal == 0 && $fieldValue != "0") || ($parsedVal == 1 && $fieldValue != "1"))){
											$this->addError("{$fieldName} - Must be an integer!");
										} else {
											$this->$fieldName = $parsedVal;
										}
										break;
									}
									case "double":{
										$parsedVal = floatval($fieldValue);
										if(!is_double($fieldValue) && (($parsedVal == 0 && $fieldValue != "0") || ($parsedVal == 1 && $fieldValue != "1"))){
											$this->addError("{$fieldName} - Must be a double!");
										} else {
											$this->$fieldName = $parsedVal;
										}
										break;
									}
									case "float":{
										$parsedVal = floatval($fieldValue);
										if(!is_float($fieldValue) && (($parsedVal == 0 && $fieldValue != "0") || ($parsedVal == 1 && $fieldValue != "1"))){
											$this->addError("{$fieldName} - Must be a float!");
										} else {
											$this->$fieldName = $parsedVal;
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
				$this->addError("{$key} - Rule not found!");
			}
		}
		return !(count($this->errors));
	}

	public function resetAllAttributes() {
        $this->oldAttributes = $this->attributes;
        $this->rules = $this->rules();

        foreach($this->attributes as $key => $val) {
            if($key == "id") { continue; }
            foreach ($this->rules as $value){
                if(is_array($value)){
                    foreach ($value[0] as $fieldName){
                        if($fieldName == $key){
                            foreach ($value[1] as $dataRule){
                                switch($dataRule){
                                    case "integer": { $this->attributes[$key] = 0; break; }
                                    case "float": { $this->attributes[$key] = 0; break; }
                                    case "double": { $this->attributes[$key] = 0; break; }
                                    case "number": { $this->attributes[$key] = 0; break; }
                                    case "string": { $this->attributes[$key] = ""; break; }
                                    case "email": { $this->attributes[$key] = ""; break; }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
	
	public function load($post){
        $this->resetAllAttributes(); // NOTE(Caupo 13.06.2019): This is for posting checbox status. Because post wont give unchecked checbox state to $_POST array. So we need to reset all.

		if(isset($post) && is_array($post) && count($post)){
			foreach ($post as $key => $value) {
                if($value === "on") {
                    $value = 1;
                }
				$this->attributes[$key] = $value;
				$this->$key = $value;
			}
			return true;
		}

        $this->attributes = $this->oldAttributes;
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