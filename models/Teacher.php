<?php

namespace app\models;

use app\components\ActiveRecord;

class Teacher extends ActiveRecord {
	
	public static function tableName() {
		return "teacher";
	}
	
	public function rules(){
		return[
			[['firstname', 'lastname', 'email', 'created_at'], ["string"]],
			[['id', 'created_by'], ["integer"]]
		];
	}
}

?>