<?php

namespace app\controllers;
	
class AdminController extends BaseController {

	public function behaviors() {
        return [
            "logged-in-required" => true
        ];
    }
	
	public function actionIndex($params) { 
		return $this->render("index", ["tere" => "uus v��rtus"]);
	}

}

?>