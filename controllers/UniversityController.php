<?php
namespace app\controllers;

use app\models\University;
use app\models\User;
use app\components\QueryBuilder;
use Exception;
	
class UniversityController extends BaseController {

	public function behaviors() {
        return [
            "logged-in-required" => true
        ];
    }

    public function actionIndex() {
        $models = University::find()->all();
        return $this->render("index", ["models" => $models]);
    }
    public function actionIndexPartial() {
        $models = University::find()->all();
        return $this->renderPartial("index", ["models" => $models]);
    }
	
	public function actionCreate() {
		$model = new University();
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
		$user = User::find()->addWhere("=", "id", $model->created_by)->one();
		return $this->render("view", ["model" => $model, "user" => $user]);
	}
	
	public function findModel($id) {
		$model = new University();
		$data = QueryBuilder::select(University::tableName())->addWhere("=", "id", $id)->query();
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Page not found");
	}

	public function actionGetResults(){
		//  TODO p2ring v2lja m6elda, oodata searchIndexi valmimist
		foreach($_POST["filtersArr"] as $key => $value){
			switch($key){
				case("degree"):{
					break;
				}
				case("semester"):{
					break;
				}
				case("speciality"):{
					break;
				}
				case("practice"):{
					break;
				}
				case("topicsArr"):{
					break;
				}	
			}
		}
		return json_encode();
	}

}

?>