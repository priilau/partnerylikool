<?php

namespace app\models;

use app\components\ActiveRecord;

class Topic_search extends ActiveRecord {

	public static function tableName() {
		return "topic_search";
	}

	public function rules(){
		return[

			[['id', 'topic_id', 'search_index_id'], ["integer"]],
		];
	}
}

?>
