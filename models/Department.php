<?php

namespace app\models;

use app\components\ActiveRecord;

class Department extends ActiveRecord {
	
	public static function tableName() {
		return "department";
	}
	
	public function rules(){
		return[
			[['name', 'created_at'], ["string"]],
			[['id', 'university_id'], ["integer"]],
			[['created_by'], ["auto-user-id"]]
		];
	}

	public function beforeDelete() {
		$entities = Speciality::find()->addWhere("=", "university_id", $this->id)->all();
		foreach ($entities as $entity) {
			$entity->delete();
		}
		parent::beforeDelete();
	}
}

?>