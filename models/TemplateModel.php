<?php
namespace app\models;
	
class TemplateModel {
	
	public static function tableName(){
		return "tableName";
	}

	public function rules(){
		return [
			[["field1","field2"],["string"]] //options: string, integer, float, double
		];
	}
}

?>