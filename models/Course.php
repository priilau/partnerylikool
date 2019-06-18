<?php

namespace app\models;

use app\components\ActiveRecord;
use app\components\QueryBuilder;

class Course extends ActiveRecord {
    public $teachers;
    public $courseTeahcers;
    public $outcomes;
	
	public static function tableName() {
		return "course";
	}
	
	public function rules(){
		return[
			[['code', 'name', 'goals', 'description', 'semester'], ["string"]],
			[['id', 'department_id', 'study_module_id', 'ects', 'optional', 'contact_hours', 'exam', 'degree'], ["integer"]],
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
            "name" => "Kursuse nimi",
            "goals" => "Õppeaine eesmärgid",
            "description" => "Õppeaine kirjeldus",
            "ects" => "ECTS/EAP",
            "semester" => "Semester",
            "contact_hours" => "Kontakttunnid",
            "exam" => "Eksam",
        ];
    }

    public function getOutcomes() {
        if(count($this->outcomes) <= 0) {
            $this->outcomes = CourseLearningOutcome::find()->addWhere("=", "course_id", $this->id)->all();
        }
        return $this->outcomes;
    }

    public function getTeachers() {
	    $this->getCourseTeachers();
	    $this->teachers = [];

	    foreach($this->courseTeahcers as $courseTeahcer) {
	        $teacher = Teacher::find()->addWhere("=", "id", $courseTeahcer->teacher_id)->one();
	        if($teacher != null) {
	            $this->teachers[] = $teacher;
            }
        }

        return $this->teachers;
    }

    public function getCourseTeachers() {
        if(count($this->courseTeahcers) <= 0) {
            $this->courseTeahcers = CourseTeacher::find()->addWhere("=", "course_id", $this->id)->all();
        }
        return $this->courseTeahcers;
    }
}

?>
