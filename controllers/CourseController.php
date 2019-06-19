<?php
namespace app\controllers;

use app\models\Course;
use app\models\User;
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
		$departmentNames = Department::find()->allNames();
		$studyModuleNames = StudyModule::find()->allNames();
		$userNames = User::find()->allNames();
		return $this->render("index", ["models" => $models, "departmentNames" => $departmentNames, "studyModuleNames" => $studyModuleNames, "userNames" => $userNames]);
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
		$department = Department::find()->addWhere("=", "id", $model->department_id)->one();
		$studyModule = StudyModule::find()->addWhere("=", "id", $model->study_module_id)->one();
		$user = User::find()->addWhere("=", "id", $model->created_by)->one();
		return $this->render("view", ["model" => $model, "department" => $department, "studyModule" => $studyModule, "user" => $user]);
	}

    public function actionSave() {
        $model = new Course();
        $model->load($_POST);
        $model->save();

        return $this->json(json_encode(["status" => $model->hasErrors() ? "failed" : "success", "attributes" => $model->attributes, "messages" => $model->showErrorsAsHtml()]));
    }

    public function actionRemove() {
        $model = new Course();
        $model->load($_POST);
        $model->delete();

        return $this->json(json_encode(["status" => $model->hasErrors() ? "failed" : "success", "attributes" => $model->attributes, "messages" => $model->showErrorsAsHtml()]));
    }

    public function actionGetTeachers() {
        $model = new Course();
        $model->load($_POST);

        return $this->json(json_encode(["status" => $model->hasErrors() ? "failed" : "success", "teachers" => $model->getTeachers(), "messages" => $model->showErrorsAsHtml()]));
    }

    public function actionGetOutcomes() {
        $model = new Course();
        $model->load($_POST);

        return $this->json(json_encode(["status" => $model->hasErrors() ? "failed" : "success", "outcomes" => $model->getOutcomes(), "messages" => $model->showErrorsAsHtml()]));
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