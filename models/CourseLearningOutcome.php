<?php

namespace app\models;

use app\components\ActiveRecord;

class CourseLearningOutcome extends ActiveRecord {
	
	public static function tableName() {
		return "course_learning_outcome";
	}
	
	public function rules(){
		return[
			[['outcome'], ["string"]],
			[['id', 'course_id'], ["integer"]],
			[['created_at'], ["created-datetime"]],
			[['created_by'], ["auto-user-id"]]
		];
	}
}

?>