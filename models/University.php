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
	
	public function resetSearchIndex() {
		$departments = QueryBuilder::select(self::tableName())->addWhere("=", "university_id", $this->id)->queryAll();
		foreach ($departments as $department) {
			$str = $department->name;
			$words = explode(" ", $str);
			foreach ($words as $word) {
				$keyword = new SearchIndex();
				$keyword->$university_id = $this->id;
				$keyword->keyword = $word;
			}
		}
		$specialities = QueryBuilder::select(self::tableName())->addWhere("=", "department_id", $this->department_id)->queryAll();
		foreach ($specialities as $speciality) {
			$str = $speciality->name;
			$words = explode(" ", $str);
			foreach ($words as $word) {
				$keyword = new SearchIndex();
				$keyword->$university_id = $this->id;
				$keyword->keyword = $word;
			}
		}
	}
}

?>