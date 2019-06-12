<?php

namespace app\models;

use app\components\ActiveRecord;

class PartnerUniversitySystemLog extends ActiveRecord {
	
	public static function tableName() {
		return "partner_university_system_log";
	}
	
	public function rules(){
		return[
			[['updated_table', 'json_string', 'created_at'], ["string"]],
			[['id', 'user_id', 'updated_id'], ["integer"]]
		];
	}
}

?>