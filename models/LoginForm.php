<?php

namespace app\models;

use app\models\BaseModel;

class LoginForm extends BaseModel {

	public function rules(){
		return[
			[['username', 'password'], ["string"]],
		];
	}
	
}

?>