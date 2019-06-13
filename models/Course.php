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
		QueryBuidler::delete(CourseLearningOutcome::tableName(), ["=", "course_id", $this->id])->execute();
		QueryBuidler::delete(CourseTeacher::tableName(), ["=", "course_id", $this->id])->execute();
		parent::beforeDelete();
	}
	
    public function attributeLabels() {
        return [
            "department_id" => "Department",
            "study_module_id" => "Study Module",
        ];
    }
}

?>