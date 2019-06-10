<?php

namespace app\models;

use app\components\ActiveRecord;

class Department extends ActiveRecord {
	
	public static function tableName() {
		return "department";
	}
	
	public function rules(){
		return[
			[['name', 'created_at'], ["string"]],
			[['id', 'university_id', 'created_by'], ["integer"]]
		];
	}
}

?>