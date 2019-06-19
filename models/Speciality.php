<?php

namespace app\models;

use app\components\ActiveRecord;

class Speciality extends ActiveRecord {
	public $studyModules;

	public static function tableName() {
		return "speciality";
	}

	public function rules(){
		return[
			[['name', 'general_information', 'instruction', 'examinations'], ["string"]],
			[['id', 'department_id', 'degree', 'practice'], ["integer"]],
			[['created_at'], ["created-datetime"]],
			[['created_by'], ["auto-user-id"]]
		];
	}

	public function beforeDelete() {
		$entities = StudyModule::find()->addWhere("=", "speciality_id", $this->id)->all();
		foreach ($entities as $entity) {
			$entity->delete();
		}
		parent::beforeDelete();
	}

	public function attributeLabels() {
		return [
			"department_id" => "Instituut",
			"general_information" => "Üldinformatsioon",
			"instruction" => "Juhendid",
			"examinations" => "Hindamismeetod",
			"name" => "Nimetus",
			"created_at" => "Lisatud",
			"created_by" => "Lisaja",
		];
	}

    public function getStudyModules() {
        if(count($this->studyModules) <= 0) {
            $this->studyModules = StudyModule::find()->addWhere("=", "speciality_id", $this->id)->all();
        }
        return $this->studyModules;
    }
}

?>
