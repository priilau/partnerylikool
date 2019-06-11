<?php
namespace app\controllers;

use app\models\CourseTeacher;
use app\components\QueryBuilder;
use Exception;
	
class CourseTeacherController extends BaseController {
	
	public function actionIndex() {
		$models = CourseTeacher::find()->all();
		return $this->render("index", ["models" => $models]);
	}
	
	public function actionCreate() {
		$model = new CourseTeacher();
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
		$model = new CourseTeacher();
		$data = QueryBuilder::select(CourseTeacher::tableName())->addWhere("=", "id", $id)->query();
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Page not found");
	}

}

?>