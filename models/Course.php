<?php

namespace app\models;
	
class Course extends BaseModel {
	
	public static function tableName() {
		return "course";
	}
	
	public function rules(){
		return[
			[['code', 'name', 'created_at'], ["string"]],
			[['id', 'department_id', 'parent_course_id', 'eap', 'optional', 'created_by', 'semester'], ["integer"]]
		]
	}
	
}

?>