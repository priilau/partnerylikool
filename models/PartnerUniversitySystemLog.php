<?php

namespace app\models;

use app\components\ActiveRecord;
use app\components\Identity;
use app\components\QueryBuilder;

class PartnerUniversitySystemLog extends ActiveRecord {
	
	public static function tableName() {
		return "partner_university_system_log";
	}
	
	public function rules(){
		return[
			[['updated_table', 'json_string'], ["string"]],
			[['id', 'user_id', 'updated_id'], ["integer"]],
			[['created_at'], ["created-datetime"]]
		];
	}

	public static function log($updatedTable, $jsonStr, $updatedId){
		if($updatedTable == "search_index"){
			return;
		}
		$model = new PartnerUniversitySystemLog;
		$model->user_id = Identity::getUserId();
		$model->updated_table = $updatedTable;
		$model->json_string = $jsonStr;
		$model->updated_id = $updatedId;
		QueryBuilder::insert(self::tableName(), $model->attributes)->execute();
	}
}

?>