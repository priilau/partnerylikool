<?php

namespace app\models;

use app\components\ActiveRecord;

class Topic extends ActiveRecord {

	public static function tableName() {
		return "topic";
	}

	public function rules(){
		return[
			[['name'], ["string"]],
			[['id'], ["integer"]],
			[['created_at'], ["created-datetime"]],
			[['created_by'], ["auto-user-id"]]
		];
	}
	public function attributeLabels() {
		return [
			"name" => "Nimetus",
			"created_at" => "Lisatud",
			"created_by" => "Lisaja",
		];
	}
}

?>
