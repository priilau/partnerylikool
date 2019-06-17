<?php
namespace app\controllers;

use app\models\CourseLearningOutcome;
use app\models\Course;
use app\models\User;
use app\components\QueryBuilder;
use Exception;
	
class CourseLearningOutcomeController extends BaseController {

	public function behaviors() {
        return [
            "logged-in-required" => true
        ];
    }
	
	public function actionIndex() {
		$models = CourseLearningOutcome::find()->all();
		$courseNames = Course::find()->allNames();
		$userNames = User::find()->allNames();
		return $this->render("index", ["models" => $models, "courseNames" => $courseNames, "userNames" => $userNames]);
	}
	
	public function actionCreate() {
		$model = new CourseLearningOutcome();
		$options = Course::find()->allNames();
		if($model->load($_POST) && $model->save()){
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("create", ["model" => $model, "options" => $options]);
		}
		
	}
	
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		$options = Course::find()->allNames();
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
		$course = Course::find()->addWhere("=", "id", $model->course_id)->one();
		$user = User::find()->addWhere("=", "id", $model->created_by)->one();
		return $this->render("view", ["model" => $model, "course" => $course, "user" => $user]);
	}
	
	public function findModel($id) {
		$model = new CourseLearningOutcome();
		$data = QueryBuilder::select(CourseLearningOutcome::tableName())->addWhere("=", "id", $id)->query();
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Page not found");
	}

}

?>