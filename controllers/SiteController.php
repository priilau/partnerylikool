<?php

namespace app\controllers;
	
class SiteController extends BaseController {
	
	public function actionIndex($params) {
		return $this->render("index", ["tere" => "uus vההrtus"]);
	}
	
}

?>