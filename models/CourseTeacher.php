<?php

namespace app\models;

use app\components\ActiveRecord;

class CourseTeacher extends ActiveRecord {

	public static function tableName() {
		return "course_teacher";
	}

	public function rules(){
		return[
			[['created_at'], ["created-datetime"]],
			[['id', 'course_id', 'teacher_id'], ["integer"]]
		];
	}
	public function attributeLabels() {
			return [
					"course_id" => "Course",
					"teacher_id" => "Teacher",
			];
	}
}

?>
