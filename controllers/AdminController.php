<?php

namespace app\controllers;
	
class AdminController extends BaseController {
	
	public function actionIndex($params) { 
		return $this->render("index", ["tere" => "uus vההrtus"]);
	}

}

?>