<?php
namespace app\controllers;

use app\models\University;
use app\components\QueryBuilder;
use Exception;
	
class UniversityController extends BaseController {
	
	public function actionIndex() {
		$models = University::find()->all();
		return $this->render("index", ["models" => $models]);
	}
	
	public function actionCreate() {
		$model = new University();
		if($model->load($_POST) && $model->save()){
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("create", ["model" => $model]);
		}
		
	}
	
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		
		if($model->load($_POST) && $model->save()){
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("update", ["model" => $model]);
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
		$model = new \app\models\University();
		$data = \app\components\QueryBuilder::select(\app\models\University::tableName())->addWhere("=", "id", $id)->query();
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Page not found");
	}

	public function actionAjax() {
		return $this->json(json_encode(["message" => "straight out of compton"]));
	}
}

?>