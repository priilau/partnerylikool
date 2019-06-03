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

            if(isset($urlParts[1]) && strlen($urlParts[1]) > 0) {
                $controller = $urlParts[1];
            }
            if(isset($urlParts[2]) && strlen($urlParts[2]) > 0) {
                $action = $urlParts[2];
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