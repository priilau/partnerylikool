<?php

namespace app\models;

use app\components\ActiveRecord;
	
class User extends BaseModel {
	
	public static function tableName() {
		return "user";
	}
	
	public function rules(){
		return[
			[['email', 'password', 'auth_key', 'created_at'], ["string"]],
			[['id'], ["integer"]]
		];
	}
}

?>