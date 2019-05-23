<?php
use app\models\Course;

namespace app\controllers;
	
class CourseController extends BaseController {
	
	public function actionIndex() {
		return $this->render("index");
	}
	
	public function actionCreate() {
		$model = new Course();
		
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
	
	protected function findModel($id) 
    {
		$model = new Course();
		$data = QueryBuilder::select(Course::tableName())->addWhere("=", "id", $id)->query();
        
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Not found");
		
    }
}

?>