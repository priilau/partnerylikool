<?php
namespace app\models;

class University extends BaseModel {
	
	public static function tableName() {
		return "university";
	}
	
	public function rules(){
		return[
			[['name', 'country', 'contact_email', 'created_at'], ["string"]],
			[['id', 'courses_available', 'recommended', 'created_by'], ["integer"]]
		];
	}
}

?>