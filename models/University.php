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
			[['name', 'country', 'homepage_url'], ["string"]],
			[['contact_email'], ['email']],
			[['id', 'courses_available', 'recommended'], ["integer"]],
			[['created_at'], ["created-datetime"]],
			[['created_by'], ["auto-user-id"]]
		];
	}

	public function afterSave() {
		$this->resetSearchIndex();
        parent::afterSave();
	}

	public function addToSearch($str) {
		$words = explode(" ", strtolower($str));
		$words = array_flip($words);

		foreach ($words as $word => $value) {
			if(strlen($word) > 2){
				$index = new SearchIndex();
				$index->university_id = $this->id;
				$index->keyword = $word;
				$index->save();
			}
		}
	}

	public function resetSearchIndex() {
		QueryBuilder::delete(SearchIndex::tableName(), ["=", "university_id", $this->id])->execute();
		$str = "{$this->name} {$this->country} ";
		$departments = Department::find()->addWhere("=", "university_id", $this->id)->all();

		foreach ($departments as $department) {
			$str .= $department->name." ";
			$specialities = Speciality::find()->addWhere("=", "department_id", $department->id)->all();
			
			foreach ($specialities as $speciality) {
				$str .= "{$speciality->name} {$speciality->general_information} {$speciality->instruction} {$speciality->examinations} ";

				if($speciality->practice){
					$str .= "-o_p-";
				}

				$studyModules = StudyModule::find()->addWhere("=", "speciality_id", $speciality->id)->all();
				
				foreach ($studyModules as $studyModule) {
					$str .= $studyModule->name." ";
					$courses = Course::find()->addWhere("=", "study_module_id", $studyModule->id)->all();
					$this->courses_available = count($courses);
					QueryBuilder::update(self::tableName(), ["courses_available" => $this->courses_available], ["=", "id", $this->id])->execute();

					foreach ($courses as $course) {
						$str .= "{$course->code} {$course->name} ";
						$learningOutcomes = CourseLearningOutcome::find()->addWhere("=", "course_id", $course->id)->all();

						foreach ($learningOutcomes as $learningOutcome) {
							$str .= $learningOutcome->outcome." ";
						}
					}
				}
			}
		}
		$this->addToSearch($str);
	}

	public function beforeDelete() {
		QueryBuilder::delete(SearchIndex::tableName(), ["=", "university_id", $this->id])->execute();
		$entities = Department::find()->addWhere("=", "university_id", $this->id)->all();
		foreach ($entities as $entity) {
			$entity->delete();
		}
		parent::beforeDelete();
	}
	public function attributeLabels() {
			return [
					"name" => "Nimi",
					"country" => "Riik",
					"contact_email" => "Kontakt email",
					"created_at" => "Lisatud",
					"created_by" => "Lisaja",
					"courses_available" => "Vabad Õppeained",
					"recommended" => "Soovitatud",
			];
	}
}

?>
