<?php

namespace app\models;

use app\components\ActiveRecord;

class StudyModule extends ActiveRecord {
	
	public static function tableName() {
		return "study_modules";
	}
	
	public function rules(){
		return[
			[['name', 'created_at'], ["string"]],
			[['id', 'speciality_id'], ["integer"]],
			[['created_by'], ["auto-user-id"]]
		];
	}
}

?>