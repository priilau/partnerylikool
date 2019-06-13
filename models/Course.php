<?php

namespace app\models;

use app\components\ActiveRecord;

class Course extends ActiveRecord {
	
	public static function tableName() {
		return "course";
	}
	
	public function rules(){
		return[
			[['code', 'name', 'goals', 'description'], ["string"]],
			[['id', 'department_id', 'study_module_id', 'ects', 'optional', 'semester', 'contact_hours', 'exam'], ["integer"]],
			[['created_at'], ["created-datetime"]],
			[['created_by'], ["auto-user-id"]]
		];
	}
}

?>