<?php
namespace app\controllers;

use app\models\Teacher;
use app\models\User;
use app\components\QueryBuilder;
use Exception;
	
class TeacherController extends BaseController {

	public function behaviors() {
        return [
            "logged-in-required" => true
        ];
    }
	
	public function actionIndex() {
		$models = Teacher::find()->all();
		$userNames = User::find()->allNames();
		return $this->render("index", ["models" => $models, "userNames" => $userNames]);
	}
	
	public function actionCreate() {
		$model = new Teacher();
		if($model->load($_POST) && $model->save()) {
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("create", ["model" => $model]);
		}
		
	}
	
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		
		if($model->load($_POST) && $model->save()) {
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
		$user = User::find()->addWhere("=", "id", $model->created_by)->one();
		return $this->render("view", ["model" => $model, "user" => $user]);
	}
	
	public function findModel($id) {
		$model = new Teacher();
		$data = QueryBuilder::select(Teacher::tableName())->addWhere("=", "id", $id)->query();
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Page not found");
	}

}

?>