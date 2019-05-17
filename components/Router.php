<?php
use app\controllers\BaseController;

namespace app\components;

class Router {
	
	public function parseUrl() {
		$controller = "";
		$action = "";
		$params = [];
		
		// TODO
		// Teha kindlaks action ja controller $_SERVER['REDIRECT_URL']
		// Parsida arraysse GET'iga tulnud väärtused $_SERVER['QUERY_STRING']
		
		$baseController = 'app\controllers\BaseController';
		$instance = new $baseController;
		$instance->initialAction("actionIndex", "SiteController", ["tere" => "tere-tekst"]);
		//$instance->render("index", ["tere" => "tere-tekst"]);
	}
	
}

?>