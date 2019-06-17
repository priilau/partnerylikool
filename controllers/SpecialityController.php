<?php
namespace app\controllers;

use app\models\Speciality;
use app\models\Department;
use app\models\User;
use app\components\QueryBuilder;
use Exception;
	
class SpecialityController extends BaseController {

	public function behaviors() {
        return [
            "logged-in-required" => true
        ];
    }
	
	public function actionIndex() {
		$models = Speciality::find()->all();
		$departmentNames = Department::find()->allNames();
		$userNames = User::find()->allNames();
		return $this->render("index", ["models" => $models, "departmentNames" => $departmentNames, "userNames" => $userNames]);
	}
	
	public function actionCreate() {
		$model = new Speciality();
		$options = Department::find()->allNames();
		if($model->load($_POST) && $model->save()){
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("create", ["model" => $model, "options" => $options]);
		}
		
	}
	
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		$options = Department::find()->allNames();
		if($model->load($_POST) && $model->save()){
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("update", ["model" => $model, "options" => $options]);
		}
	}
	
	public function actionDelete($id) {
		$model = $this->findModel($id);
		$model->delete();
		return $this->redirect("index");
	}
	
	public function actionView($id) {
		$model = $this->findModel($id);
		$department = Department::find()->addWhere("=", "id", $model->department_id)->one();
		$user = User::find()->addWhere("=", "id", $model->created_by)->one();
		return $this->render("view", ["model" => $model, "department" => $department, "user" => $user]);
	}
	
	public function findModel($id) {
		$model = new Speciality();
		$data = QueryBuilder::select(Speciality::tableName())->addWhere("=", "id", $id)->query();
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Page not found");
	}

}

?>