<?php

namespace app\models;

use app\components\ActiveRecord;

class Department extends ActiveRecord {
	public $specialities;

	public static function tableName() {
		return "department";
	}

	public function rules(){
		return[
			[['name'], ["string"]],
			[['id', 'university_id'], ["integer"]],
			[['created_at'], ["created-datetime"]],
			[['created_by'], ["auto-user-id"]]
		];
	}

	public function beforeDelete() {
		$entities = Speciality::find()->addWhere("=", "department_id", $this->id)->all();
		foreach ($entities as $entity) {
			$entity->delete();
		}
		parent::beforeDelete();
	}

	public function attributeLabels() {
		return [
			"university_id" => "Ülikool",
			"name" => "Ülikooli nimi",
 		];
	}

    public function getSpecialities() {
        if(count($this->specialities) <= 0) {
            $this->specialities = Speciality::find()->addWhere("=", "department_id", $this->id)->all();
        }
        return $this->specialities;
    }
}

?>
