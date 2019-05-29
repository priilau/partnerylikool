<?php
use app\components\QueryBuilder;

namespace app\models;
	
class BaseModel {
	protected $attributes = [];
	public $errors = [];
	public $rules = [];

	function __construct() {
		$this->rules = $this->rules();
		if(is_array($this->rules)){
			foreach ($this->rules as $value){
				if(is_array($value)){
					foreach ($value[0] as $fieldName){
						$attributes[$fieldName] = null;
					}
				}
			}
		}
	}
	
	public function getSaveQuery(){
		if(isset($this->attributes["id"]) && $this->attributes["id"] > 0){
			return \app\components\QueryBuilder::update(static::tableName(), $this->attributes, ["=","id",$this->attributes["id"]])->compose();
		}
		return \app\components\QueryBuilder::insert(static::tableName(), $this->attributes)->compose();
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
	}
	
	public function showErrorsAsHtml(){
		$html = "";
		foreach ($errors as $key => $error){
			$html .= ($key+1).$error."<br>";
		}
		return $html;
	}
	
	public function save(){
		if($this->validate()){
			if(isset($attributes["id"]) && $attributes["id"] > 0){
				QueryBuilder::update(self::tableName(), $attributes, ["=","id",$attributes["id"]])->execute();
			} else {
				$attributes["id"] = QueryBuilder::insert(self::tableName(), $attributes)->execute();
				if ($attributes["id"] == 0){
					$this->addError("Model save insert failed!");
					return false;
				}
			}
			return true;
		}
		return false;
	}
	
	public function validate(){
		$errors = [];
		foreach ($attributes as $key => $fieldValue){
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
											$this->addError($fieldName." - Must be a string!");
										}
										break;
									}
									case "integer":{
										if(!is_int($fieldValue)){
											$this->addError($fieldName." - Must be an integer!");
										}
										break;
									}
									case "double":{
										if(!is_double($fieldValue)){
											$this->addError($fieldName." - Must be a double!");
										}
										break;
									}
									case "float":{
										if(!is_float($fieldValue)){
											$this->addError($fieldName." - Must be a float!");
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
				$this->addError($fieldName." - Rule not found!");
			}
		}
		return !(count($errors));
	}
	
	public function load($post){
		if(isset($post) && is_array($post) && count($post)){
			foreach ($post as $key => $value) {
				if (isset($attributes[$key])){ //võtab postist ja määrab value kui atribuut on olemas
					$attributes[$key] = $value;
				}
			}		
			return true;
		}
		return false;
	}
	
	public function delete(){
		QueryBuilder::delete(self::tableName(), ["id" => $this->id])->execute();
	}

}

?>