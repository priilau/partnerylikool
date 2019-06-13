<?php

namespace app\models;

use app\components\ActiveRecord;

class Speciality extends ActiveRecord {

	public static function tableName() {
		return "speciality";
	}

	public function rules(){
		return[
			[['name', 'general_information', 'instruction', 'examinations'], ["string"]],
			[['id', 'department_id'], ["integer"]],
			[['created_at'], ["created-datetime"]],
			[['created_by'], ["auto-user-id"]]
		];
	}
	public function attributeLabels() {
			return [
					"department_id" => "Department",
			];
	}
}

?>
