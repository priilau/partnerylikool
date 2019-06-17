<?php
namespace app\models;

use app\config\DB;
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

	public static function getAllWithIds($ids){
		$dataFromDb = [];
		$sql = "SELECT id, keyword FROM search_index WHERE id IN ({$ids});";

		$mysqli = new \mysqli(DB::$host, DB::$user, DB::$pw, DB::$name);
		$stmt = $mysqli->prepare($sql); 
		if(!$stmt){
			echo $mysqli->error;
			exit("Unable to create stmt!");
		}
		$stmt->execute();
		$result = $stmt->get_result();

		while($row = $result->fetch_assoc()){
			$dataFromDb[] = $row;
		}

		$data = [];
		foreach ($dataFromDb as $key => $value) {
			$data[$value["id"]] = $value["keyword"];
		}
		$stmt->close();
		$mysqli->close();
		return $data;
	}
}
?>