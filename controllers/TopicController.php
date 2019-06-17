<?php
namespace app\controllers;

use app\models\Topic;
use app\models\TopicSearch;
use app\models\SearchIndex;
use app\components\QueryBuilder;
use Exception;

class TopicController extends BaseController {

  public function behaviors() {
        return [
            "logged-in-required" => true
        ];
    }

  	public function actionIndex() {
  		$models = Topic::find()->all();
  		return $this->render("index", ["models" => $models]);
  	}

  	public function actionCreate() {
		$model = new Topic();
		$modelPost = [];
		
		if(isset($_POST["name"])) {
			$modelPost["name"] = $_POST["name"];
		}
  		if($model->load($modelPost) && $model->save()){
  			return $this->json($model->id);
  		} else {
			$topicSearches = TopicSearch::find()->addWhere("=", "topic_id", $model->id)->all();
			$searchIndexes = SearchIndex::find()->all();
  			return $this->render("create", ["model" => $model, "topicSearches" => $topicSearches, "searchIndexes" => $searchIndexes]);
  		}
  	}

  	public function actionUpdate($id) {
  		$model = $this->findModel($id);
		$modelPost = [];

		if(isset($_POST["name"])){
			$modelPost["name"] = $_POST["name"];
		}
		if($model->load($modelPost) && $model->save()){
  			return $this->json($model->id);
  		} else {
			$topicSearches = TopicSearch::find()->addWhere("=", "topic_id", $model->id)->all();
			$searchIdStr = "";
			
			foreach ($topicSearches as $topicSearch) {
				$searchIdStr .= "{$topicSearch->search_index_id}, ";
			}
			$searchIdStr = rtrim($searchIdStr, ", ");
			if(strlen($searchIdStr) > 0){
				$searches = SearchIndex::getAllWithIds($searchIdStr);
			} else {
				$searches = [];
			}

			$searchIndexes = SearchIndex::find()->all();
			$keywords = [];
			foreach ($searchIndexes as $index => $name) {
				$keywords[] = $name->keyword;
			}
			$keywords = array_flip(array_flip($keywords));
  			return $this->render("update", ["model" => $model, "topicSearches" => $searches, "searchIndexes" => $keywords]);
  		}
  	}

  	public function actionDelete($id) {
  		$model = $this->findModel($id);
  		$model->delete();
  		return $this->redirect("index");
  	}

  	public function actionView($id) {
  		$model = $this->findModel($id);
  		return $this->render("view", ["model" => $model]);
  	}

  	public function findModel($id) {
  		$model = new Topic();
  		$data = QueryBuilder::select(Topic::tableName())->addWhere("=", "id", $id)->query();
  		if($model->load($data)){
  			return $model;
  		}
  		throw new Exception("Page not found");
  	}
}

?>
