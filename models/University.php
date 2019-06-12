<?php

namespace app\models;

use app\components\ActiveRecord;

class University extends ActiveRecord {
	
	public static function tableName() {
		return "university";
	}
	
	public function rules(){
		return[
			[['name', 'country', 'created_at'], ["string"]],
			[['contact_email'], ['email']],
			[['id', 'courses_available', 'recommended'], ["integer"]],
			[['created_by'], ["auto-user-id"]]
		];
	}
}

?>