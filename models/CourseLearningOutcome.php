<?php

namespace app\models;

use app\components\ActiveRecord;

class CourseLearningOutcome extends ActiveRecord {
	
	public static function tableName() {
		return "course_learning_outcomes";
	}
	
	public function rules(){
		return[
			[['outcome', 'created_at'], ["string"]],
			[['id', 'course_id'], ["integer"]],
			[['created_by'], ["auto-user-id"]]
		];
	}
}

?>