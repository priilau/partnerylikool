<?php
use app\controllers\BaseController;

namespace app\components;

class Router {
	
	public function parseUrl() {
		$controller = "site";
		$action = "index";
		$params = [];
		// TODO
		// Teha kindlaks action ja controller $_SERVER['REDIRECT_URL']
		// Parsida arraysse GET'iga tulnud väärtused $_SERVER['QUERY_STRING']
		
		//var_dump($_SERVER['REDIRECT_URL'], explode("/", $_SERVER['REDIRECT_URL']));die;
		$urlParts = explode("/", $_SERVER['REDIRECT_URL']);
		
		if(isset($urlParts[1]) && strlen($urlParts[1]) > 0) {
			$controller = $urlParts[1];
		}
		if(isset($urlParts[2]) && strlen($urlParts[2]) > 0) {
			$action = $urlParts[2];
		}
		
		$paramStr = ltrim($_SERVER['QUERY_STRING'], '?');
		$paramParts = explode("&", $paramStr);
		
		foreach($paramParts as $part) {
			$parts = explode("=", $part);
			if(isset($parts[0]) && isset($parts[1])) {
				$params[$parts[0]] = $parts[1];	
			}
		}
		
		$baseController = 'app\controllers\BaseController';
		$instance = new $baseController;
		$instance->initialAction($action, $controller, $params);
		//$instance->render("index", ["tere" => "tere-tekst"]);
	}
	
}

?>