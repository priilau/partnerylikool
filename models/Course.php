<?php

namespace app\models;

use app\components\ActiveRecord;
use app\components\QueryBuilder;

class Course extends ActiveRecord {
	
	public static function tableName() {
		return "course";
	}
	
	public function rules(){
		return[
			[['code', 'name', 'goals', 'description'], ["string"]],
			[['id', 'department_id', 'study_module_id', 'ects', 'optional', 'semester', 'contact_hours', 'exam'], ["integer"]],
			[['created_at'], ["created-datetime"]],
			[['created_by'], ["auto-user-id"]]
		];
	}

	public function beforeDelete() {
		QueryBuilder::delete(CourseLearningOutcome::tableName(), ["=", "course_id", $this->id])->execute();
		QueryBuilder::delete(CourseTeacher::tableName(), ["=", "course_id", $this->id])->execute();
		parent::beforeDelete();
	}

    public function attributeLabels() {
        return [
            "optional" => "Valikuline",
            "department_id" => "Instituut",
            "study_module_id" => "Õppemoodul",
            "created_at" => "Lisatud",
            "created_by" => "Lisaja",
            "name" => "Ülikooli nimi",
            "goals" => "Õppeaine eesmärgid",
            "description" => "Õppeaine Kirjeldus",
            "ects" => "ECTS/EAP",
            "semester" => "Semester",
            "contact_hours" => "Kontakttunnid",
            "exam" => "Eksam",
        ];
    }
}

?>
