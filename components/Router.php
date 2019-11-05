<?php
namespace app\components;

use app\components\BaseController;

class Router {
	
	public function parseUrl() {
		$controller = "site";
		$action = "index";
		$params = [];

        if(isset($_SERVER['REDIRECT_URL']) && strlen($_SERVER['REDIRECT_URL']) > 0) {
            $urlParts = explode("/", $_SERVER['REDIRECT_URL']);
			$urlActionIndex = count($urlParts) - 1;
			$urlControllerIndex = $urlActionIndex - 1;

            if(isset($urlParts[$urlControllerIndex]) && strlen($urlParts[$urlControllerIndex]) > 0) {
                $controller = $urlParts[$urlControllerIndex];
            }
            if(isset($urlParts[$urlActionIndex]) && strlen($urlParts[$urlActionIndex]) > 0) {
                $action = $urlParts[$urlActionIndex];
            }
        }

        if(isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) {
            $paramStr = ltrim($_SERVER['QUERY_STRING'], '?');
            $paramParts = explode("&", $paramStr);

            foreach($paramParts as $part) {
                $parts = explode("=", $part);
                if(isset($parts[0]) && isset($parts[1])) {
                    $params[$parts[0]] = $parts[1];
                }
            }
        }
		
		$baseController = 'app\controllers\BaseController';
		$instance = new $baseController;
		$instance->initialAction($action, $controller, $params);
	}
	
}

?>