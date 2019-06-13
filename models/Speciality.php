<?php

namespace app\models;

use app\components\ActiveRecord;

class Speciality extends ActiveRecord {
	
	public static function tableName() {
		return "speciality";
	}
	
	public function rules(){
		return[
			[['name', 'general_information', 'instruction', 'created_at', 'examinations'], ["string"]],
			[['id', 'department_id'], ["integer"]],
			[['created_by'], ["auto-user-id"]]
		];
	}

	public function beforeDelete() {
		$entities = StudyModule::find()->addWhere("=", "university_id", $this->id)->all();
		foreach ($entities as $entity) {
			$entity->delete();
		}
		parent::beforeDelete();
	}
}

?>