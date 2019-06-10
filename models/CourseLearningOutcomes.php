<?php

namespace app\models;

use app\components\ActiveRecord;

class CourseLearningOutcomes extends ActiveRecord {
	
	public static function tableName() {
		return "course_learning_outcomes";
	}
	
	public function rules(){
		return[
			[['outcome', 'created_at'], ["string"]],
			[['id', 'course_id', 'created_by'], ["integer"]]
		];
	}
}

?>