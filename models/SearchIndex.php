<?php
namespace app\models;

use app\components\ActiveRecord;

class SearchIndex extends ActiveRecord {
    
    public function rules(){
		return[
			[['id', 'university_id'], ["integer"]],
			[['keyword'], ["string"]]
		];
	}
}
?>