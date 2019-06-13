<?php
namespace app\controllers;

use app\models\Course;
use app\models\StudyModule;
use app\models\Department;
use app\components\QueryBuilder;
use Exception;
	
class CourseController extends BaseController {

    public function behaviors() {
        return [
            "logged-in-required" => true
        ];
    }
	
	public function actionIndex() {
		$models = Course::find()->all();
		return $this->render("index", ["models" => $models]);
	}
	
	public function actionCreate() {
		$model = new Course();
		$optionsDepartment = Department::find()->allNames();
		$optionsStudyModule = StudyModule::find()->allNames();
		if($model->load($_POST) && $model->save()){
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("create", ["model" => $model, "optionsDepartment" => $optionsDepartment, "optionsStudyModule" => $optionsStudyModule]);
		}
		
	}
	
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		$optionsDepartment = Department::find()->allNames();
		$optionsStudyModule = StudyModule::find()->allNames();

		if($model->load($_POST) && $model->save()){
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("update", ["model" => $model, "optionsDepartment" => $optionsDepartment, "optionsStudyModule" => $optionsStudyModule]);
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
		$model = new Course();
		$data = QueryBuilder::select(Course::tableName())->addWhere("=", "id", $id)->query();
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Page not found");
	}

}

?>