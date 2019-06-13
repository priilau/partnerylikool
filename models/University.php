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
	
	public function afterSave() {
		$this->resetSearchIndex();
        parent::afterSave();
	}

	public function addToSearch($str) {
		$words = explode(" ", $str);
		$words = array_flip($words);

		foreach ($words as $word => $value) {
			$index = new SearchIndex();
			$index->university_id = $this->id;
        	$index->keyword = $word;
			$index->save();
		}
	}
	
	public function resetSearchIndex() {
		$departments = QueryBuilder::select(Department::tableName())->addWhere("=", "university_id", $this->id)->queryAll();
		$str = "";

		foreach ($departments as $department) {
			$str .= $department->name." ";
			$specialities = QueryBuilder::select(Speciality::tableName())->addWhere("=", "department_id", $department->id)->queryAll();
			
			foreach ($specialities as $speciality) {
				$str .= "{$speciality->name} {$speciality->general_information} {$speciality->instruction} {$speciality->examinations} ";
				$studyModules = QueryBuilder::select(StudyModule::tableName())->addWhere("=", "speciality_id", $speciality->id)->queryAll();
				
				foreach ($studyModules as $studyModule) {
					$str .= $studyModule->name." ";
					$courses = QueryBuilder::select(Course::tableName())->addWhere("=", "study_module_id", $studyModule->id)->queryAll();

					foreach ($courses as $course) {
						$str .= "{$course->code} {$course->name} ";
						$learningOutcomes = QueryBuilder::select(CourseLearningOutcome::tableName())->addWhere("=", "course_id", $course->id)->queryAll();

						foreach ($learningOutcomes as $learningOutcome) {
							$str .= $learningOutcome->outcome." ";
						}
					}
				}
			}
		}
		$this->addToSearch($str);
	}
}

?>