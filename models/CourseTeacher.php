<?php

namespace app\models;

use app\components\ActiveRecord;

class CourseTeacher extends ActiveRecord {
	
	public static function tableName() {
		return "course_teacher";
	}
	
	public function rules(){
		return[
			[['created_at'], ["string"]],
			[['id', 'course_id', 'teacher_id'], ["integer"]]
		];
	}
}

?>