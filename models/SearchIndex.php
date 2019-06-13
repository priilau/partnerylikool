<?php
namespace app\models;

use app\components\ActiveRecord;

class SearchIndex extends ActiveRecord {
	
	public function SearchIndex($uid, $word) {
        $this->university_id = $uid;
        $this->keyword = $word;
    }

    public function rules(){
		return[
			[['id', 'university_id'], ["integer"]],
			[['keyword'], ["string"]]
		];
	}
}
?>