<?php

namespace app\models;

use app\components\ActiveRecord;

class StudyModule extends ActiveRecord {

	public static function tableName() {
		return "study_module";
	}

	public function rules(){
		return[
			[['name'], ["string"]],
			[['id', 'speciality_id'], ["integer"]],
			[['created_at'], ["created-datetime"]],
			[['created_by'], ["auto-user-id"]]
		];
	}
	public function attributeLabels() {
			return [
					"speciality_id" => "Speciality",
			];
	}
}

?>
