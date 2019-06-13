<?php
namespace app\controllers;

use app\models\CourseTeacher;
use app\models\Teacher;
use app\models\Course;
use app\components\QueryBuilder;
use Exception;
	
class CourseTeacherController extends BaseController {

	public function behaviors() {
        return [
            "logged-in-required" => true
        ];
    }
	
	public function actionIndex() {
		$models = CourseTeacher::find()->all();
		$courseNames = Course::find()->allNames();
		$teacherNames = Teacher::find()->allNames();
		return $this->render("index", ["models" => $models, "courseNames" => $courseNames, "teacherNames" => $teacherNames]);
	}
	
	public function actionCreate() {
		$model = new CourseTeacher();
		$optionsCourse = Course::find()->allNames();
		$optionsTeacher = Teacher::find()->allNames();
		if($model->load($_POST) && $model->save()){
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("create", ["model" => $model, "optionsCourse" => $optionsCourse, "optionsTeacher" => $optionsTeacher]);
		}
		
	}
	
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		$optionsCourse = Course::find()->allNames();
		$optionsTeacher = Teacher::find()->allNames();
		if($model->load($_POST) && $model->save()){
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("update", ["model" => $model, "optionsCourse" => $optionsCourse, "optionsTeacher" => $optionsTeacher]);
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