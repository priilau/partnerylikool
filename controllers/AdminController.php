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
}

?>