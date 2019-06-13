<?php
namespace app\controllers;

use app\models\StudyModule;
use app\models\Speciality;
use app\components\QueryBuilder;
use Exception;
	
class StudyModuleController extends BaseController {

	public function behaviors() {
        return [
            "logged-in-required" => true
        ];
    }
	
	public function actionIndex() {
		$models = StudyModule::find()->all();
		$specialityNames = Speciality::find()->allNames();

		return $this->render("index", ["models" => $models, "specialityNames" => $specialityNames]);
	}
	
	public function actionCreate() {
		$model = new StudyModule();
		$options = Speciality::find()->allNames();
		if($model->load($_POST) && $model->save()){
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("create", ["model" => $model, "options" => $options]);
		}
		
	}
	
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		$options = Speciality::find()->allNames();
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
		return $this->render("view", ["model" => $model]);
	}
	
	public function findModel($id) {
		$model = new StudyModule();
		$data = QueryBuilder::select(StudyModule::tableName())->addWhere("=", "id", $id)->query();
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Page not found");
	}

}

?>