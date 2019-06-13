<?php
namespace app\models;

use app\components\ActiveRecord;

class SearchIndex extends ActiveRecord {
	
	public static function tableName() {
		return "search_index";
	}

    public function rules(){
		return[
			[['id', 'university_id'], ["integer"]],
			[['keyword'], ["string"]]
		];
	}
}
?>