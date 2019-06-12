<?php
namespace app\controllers;
	
class SiteController extends BaseController {
	
	public function actionIndex() {
		return $this->render("index", ["tere" => "uus v��rtus"]);
	}

	public function actionAdmin() {
        return $this->render("admin");
    }
}

?>