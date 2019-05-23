<?php

namespace app\controllers;
	
class BaseController {
	
	public function initialAction($action, $controller, $params) {
		// luua vastav objekt $controller muutuja kaudu
			/* Näide:	
				$baseController = 'app\controllers\BaseController';
				$instance = new $baseController;
			*/
		// kutsuda vastav actionFunction välja $action muutuja kaudu
			/* Juhend: 
				call_user_func_array(array($object, $action), $params);
			*/
		$controllerName = 'app\controllers\SiteController';
		$instance = new $controllerName;
		call_user_func_array([$instance, $action], $params);
	}
	
	public function render($viewName, $params) {
		global $content;
		$GLOBALS["content"] = $this->requireToVar($viewName, $params);
		$viewPath = __DIR__ . "/../views/base.php";
		require_once($viewPath);
	}
	
	public function redirect(){
		//Todo
	}
	
	public function requireToVar($viewName, $params){
		ob_start();
		if(is_array($params)) {
			foreach($params as $key => $val) {
				global ${$key};
				$GLOBALS[$key] = $val;
			}
		}
		$viewPath = __DIR__ . "/../views/".$viewName.".php";
		require_once($viewPath);
		return ob_get_clean();
	}
}

?>