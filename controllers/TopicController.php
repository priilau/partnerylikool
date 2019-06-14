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
		
  		if($model->load($_POST) && $model->save()){
  			return $this->redirect("view", ["id" => $model->id]);
  		} else {
  			return $this->render("create", ["model" => $model]);
  		}

  	}

  	public function actionUpdate($id) {
  		$model = $this->findModel($id);

		$topicSearches = TopicSearch::find()->addWhere("=", "topic_id", $model->id)->all();
		$searchIndexes = SearchIndex::find()->all();
  		if($model->load($_POST) && $model->save()){
  			return $this->redirect("view", ["id" => $model->id]);
  		} else {
  			return $this->render("update", ["model" => $model, "topicSearches" => $topicSearches, "searchIndexes" => $searchIndexes]);
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
