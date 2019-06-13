<?php

namespace app\models;

use app\components\ActiveRecord;

class Department extends ActiveRecord {
	
	public static function tableName() {
		return "department";
	}
	
	public function rules(){
		return[
			[['name'], ["string"]],
			[['id', 'university_id'], ["integer"]],
			[['created_at'], ["created-datetime"]],
			[['created_by'], ["auto-user-id"]]
		];
	}
}

?>