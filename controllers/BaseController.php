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
		$action = ucfirst($action);
		$controller = ucfirst($controller);
		$controllerName = "app\controllers\\{$controller}Controller";
		$instance = new $controllerName;
		$actionName = "action{$action}";
		call_user_func_array([$instance, $actionName], $params);
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