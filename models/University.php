<?php

namespace app\models;

use app\components\QueryBuilder;
use app\components\ActiveRecord;

class University extends ActiveRecord {
	
	public static function tableName() {
		return "university";
	}
	
	public function rules() {
		return[
			[['name', 'country', 'created_at'], ["string"]],
			[['contact_email'], ['email']],
			[['id', 'courses_available', 'recommended'], ["integer"]],
			[['created_by'], ["auto-user-id"]]
		];
	}
	
	public function beforeSave() {
		$this->resetSearchIndex();
        parent::beforeSave();
	}

	public function addToSearch($str){
		$words = explode(" ", $str);
		foreach ($words as $word) {
			(new SearchIndex($this->id, $word))->save();
		}
	}
	
	public function resetSearchIndex() {
		$departments = QueryBuilder::select(Department::tableName())->addWhere("=", "university_id", $this->id)->queryAll();

		foreach ($departments as $department) {
			$str = $department->name;
			$this->addToSearch($str);
			$specialities = QueryBuilder::select(Speciality::tableName())->addWhere("=", "department_id", $department->id)->queryAll();
			
			foreach ($specialities as $speciality) {
				$str = $speciality->name;
				$this->addToSearch($str);
				$studyModules = QueryBuilder::select(StudyModule::tableName())->addWhere("=", "speciality_id", $speciality->id)->queryAll();
				foreach ($studyModules as $studyModule) {
					$str = $studyModule->name;
					$this->addToSearch($str);
					$courses = QueryBuilder::select(Course::tableName())->addWhere("=", "study_module_id", $studyModule->id)->queryAll();
					foreach ($courses as $course) {
						$str = $course->name;
						$this->addToSearch($str);
						$learningO = QueryBuilder::select(Course::tableName())->addWhere("=", "parent_course_id", $studyModule->id)->queryAll();
					}
				}
			}
		}
	}
}

?>