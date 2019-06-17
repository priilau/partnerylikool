<?php

namespace app\models;

use app\config\DB;
use app\components\QueryBuilder;
use app\components\ActiveRecord;

class University extends ActiveRecord {
	public $courses = [];
	public $specialities = [];
	public $departments = [];
	public $searchIndexes = [];

	public static function tableName() {
		return "university";
	}

	public function rules() {
		return[
			[['name', 'country', 'description', 'homepage_url'], ["string"]],
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

	public function getCourses(){
		$sql = "SELECT DISTINCT course.semester, course.degree FROM `university` AS u LEFT JOIN `department` ON department.university_id = u.id LEFT JOIN course ON course.department_id = department.id WHERE u.id = {$this->id};";

		$mysqli = new \mysqli(DB::$host, DB::$user, DB::$pw, DB::$name);
		$stmt = $mysqli->prepare($sql); 
		if(!$stmt){
			echo $mysqli->error;
			exit("Unable to create stmt!");
		}
		$stmt->execute();
		$result = $stmt->get_result();

		while($row = $result->fetch_assoc()){
			$model = new University();
			$model->load($row);
			$this->courses[] = $model;
		}
		$stmt->close();
		$mysqli->close();
		return $this->courses;
	}

	public function getSearchIndexes(){
		$sql = "SELECT DISTINCT search_index.keyword FROM `university` AS u LEFT JOIN `search_index` ON search_index.university_id = u.id WHERE u.id = {$this->id};";

		$mysqli = new \mysqli(DB::$host, DB::$user, DB::$pw, DB::$name);
		$stmt = $mysqli->prepare($sql); 
		if(!$stmt){
			echo $mysqli->error;
			exit("Unable to create stmt!");
		}
		$stmt->execute();
		$result = $stmt->get_result();

		while($row = $result->fetch_assoc()){
			$model = new University();
			$model->load($row);
			$this->searchIndexes[] = $model;
		}
		$stmt->close();
		$mysqli->close();
		return $this->searchIndexes;
	}

	public function getSpecialities(){
		$sql = "SELECT DISTINCT speciality.degree, speciality.name FROM `university` AS u LEFT JOIN `department` ON department.university_id = u.id LEFT JOIN speciality ON speciality.department_id = department.id WHERE u.id = {$this->id};";

		$mysqli = new \mysqli(DB::$host, DB::$user, DB::$pw, DB::$name);
		$stmt = $mysqli->prepare($sql); 
		if(!$stmt){
			echo $mysqli->error;
			exit("Unable to create stmt!");
		}
		$stmt->execute();
		$result = $stmt->get_result();

		while($row = $result->fetch_assoc()){
			$model = new University();
			$model->load($row);
			$this->specialities[] = $model;
		}
		$stmt->close();
		$mysqli->close();
		return $this->specialities;
	}

	public function getDepartments() {
		if(count($this->departments) <= 0) {
            $this->departments = Department::find()->addWhere("=", "university_id", $this->id)->all();
		}
		return $this->departments;
	}
}

?>
