<?php

namespace app\controllers;

use app\models\University;

class AdminController extends BaseController {

	public function behaviors() {
        return [
            "logged-in-required" => true
        ];
    }
	
	public function actionIndex() {
        $models = University::find()->all();
        return $this->render("index", ["models" => $models]);
	}

    public function actionCreateUniversity() {
        $model = new University();
        return $this->render("create-university", ["model" => $model]);
    }

    public function actionUpdateUniversity() {
        $model = new University();
        return $this->render("update-university", ["model" => $model]);
    }
}

?>