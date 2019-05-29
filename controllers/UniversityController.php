<?php
use app\models\University;

namespace app\controllers;
	
class UniversityController extends BaseController {
	
	public function actionIndex() {
		return $this->render("index");
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
		return $this->render("university-view", ["modelQuery" => $model->getSaveQuery()]);
	}
	
	protected function findModel($id) 
    {
		$model = new University();
		$data = QueryBuilder::select(University::tableName())->addWhere("=", "id", $id)->query();
        
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Not found");
		
    }
}

?>