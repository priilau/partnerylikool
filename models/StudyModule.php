<?php

namespace app\models;

use app\components\ActiveRecord;

class StudyModule extends ActiveRecord {
	
	public static function tableName() {
		return "study_module";
	}
	
	public function rules(){
		return[
			[['name', 'created_at'], ["string"]],
			[['id', 'speciality_id'], ["integer"]],
			[['created_by'], ["auto-user-id"]]
		];
	}

	public function beforeDelete() {
		$entities = Course::find()->addWhere("=", "university_id", $this->id)->all();
		foreach ($entities as $entity) {
			$entity->delete();
		}
		parent::beforeDelete();
	}
}

?>