<?php
namespace app\controllers;

use app\models\Department;
use app\models\University;
use app\models\User;
use app\components\QueryBuilder;
use Exception;
	
class DepartmentController extends BaseController {

	public function behaviors() {
        return [
            "logged-in-required" => true
        ];
    }
	
	public function actionIndex() {
		$models = Department::find()->all();
		$universityNames = University::find()->allNames();
		$userNames = User::find()->allNames();
		return $this->render("index", ["models" => $models, "universityNames" => $universityNames, "userNames" => $userNames]);
	}
	
	public function actionCreate() {
		$model = new Department();
		$options = University::find()->allNames();
		if($model->load($_POST) && $model->save()){
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("create", ["model" => $model, "options" => $options]);
		}
		
	}
	
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		$options = University::find()->allNames();
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
		$university = University::find()->addWhere("=", "id", $model->university_id)->one();
		$user = User::find()->addWhere("=", "id", $model->created_by)->one();
		return $this->render("view", ["model" => $model, "university" => $university, "user" => $user]);
	}

	public function actionSave() {
	    $model = new Department();
	    $model->load($_POST);
        $model->save();

	    return $this->json(json_encode(["status" => $model->hasErrors() ? "failed" : "success", "attributes" => $model->attributes, "messages" => $model->showErrorsAsHtml()]));
    }

    public function actionRemove() {
        $model = new Department();
        $model->load($_POST);
        $model->delete();

        return $this->json(json_encode(["status" => $model->hasErrors() ? "failed" : "success", "attributes" => $model->attributes, "messages" => $model->showErrorsAsHtml()]));
    }

    public function actionGetSpecialities() {
        $model = new Department();
        $model->load($_POST);

        return $this->json(json_encode(["status" => $model->hasErrors() ? "failed" : "success", "specialities" => $model->getSpecialities(), "messages" => $model->showErrorsAsHtml()]));
    }
	
	public function findModel($id) {
		$model = new Department();
		$data = QueryBuilder::select(Department::tableName())->addWhere("=", "id", $id)->query();
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Page not found");
	}

}

?>