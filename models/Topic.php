<?php

namespace app\models;

use app\components\ActiveRecord;
use app\components\QueryBuilder;

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
/*
	public function afterSave() {
		$this->resetTopicSearch();
        parent::afterSave();
	}

	public function resetTopicSearch(){
		QueryBuilder::delete(TopicSearch::tableName(), ["=", "topic_id", $this->id])->execute();
		$searchIndexes = SearchIndex::find()->addWhere("=", "speciality_id", $speciality->id)->all();
		QueryBuilder::insert(TopicSearch::tableName(), ["topic_id" => $this->id, "search_index_id" => $searchIndex->id])->execute();
	}*/
}

?>
