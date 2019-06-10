<?php

namespace app\models;

use app\components\ActiveRecord;

class Speciality extends ActiveRecord {
	
	public static function tableName() {
		return "speciality";
	}
	
	public function rules(){
		return[
			[['name', 'general_information', 'instruction', 'created_at', 'examinations'], ["string"]],
			[['id', 'department_id', 'created_by'], ["integer"]]
		];
	}
}

?>