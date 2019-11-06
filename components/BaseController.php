<?php
namespace app\controllers;

use app\config\App;
use app\components\Identity;
use app\components\Request;
use app\components\Url;
use Exception;
	
class BaseController {

    public $controller = "site";
    public $action = "index";

    public function behaviors() {
        return [
            "logged-in-required" => false
        ];
    }
	
	public function initialAction($action, $controller, $params) {
        Request::setController($controller); // NOTE(Caupo 03.06.2019): Setime Requesti kaudu globalsi kuna call_user_func_array-ga tehes ei lähe edasi baseControlleri property väärtused.
        Request::setAction($action); // NOTE(Caupo 03.06.2019): Setime Requesti kaudu globalsi kuna call_user_func_array-ga tehes ei lähe edasi baseControlleri property väärtused.
        Request::setUserAgent($_SERVER["HTTP_USER_AGENT"]);
        Request::setParams($params);
        Request::setUserIP();
        Identity::validateIdentity();

        $this->action = $action;
        $this->controller = $controller;

        $controller = ucfirst($controller);
        $controllerParts = explode("-", $controller);
        if(is_array($controllerParts) && count($controllerParts) > 0) {
            $controller = "";
            foreach($controllerParts as $controllerPart) {
                $controller .= ucfirst($controllerPart);
            }
        }

        $action = ucfirst($action);
        $actionParts = explode("-", $action);
        if(is_array($actionParts) && count($actionParts) > 0) {
            $action = "";
            foreach($actionParts as $actionPart) {
                $action .= ucfirst($actionPart);
            }
        }

		$controllerName = "app\controllers\\{$controller}Controller";
		$instance = new $controllerName;
		$actionName = "action{$action}";
		$this->handleBehaviors($instance);
		call_user_func_array([$instance, $actionName], $params);
	}

	public function handleBehaviors($instance) {
        foreach($instance->behaviors() as $behavior => $behaviorValue) {
            if(is_array($behaviorValue)){
                if(isset($behaviorValue["actions"]) && isset($behaviorValue["conditions"])){
                    foreach ($behaviorValue["actions"] as $action) {
                        if($action != Request::getAction()) {
                            continue;
                        }
                        foreach($behaviorValue["conditions"] as $condition => $value){
                            switch($condition) {
                                case "logged-in-required": {
                                    if($value && Identity::isGuest()) {
                                        throw new Exception("Access denied");
                                    }
                                    break;
                                }
                            }
                        }
                    }   
                }                
            } else {
                switch($behavior) {
                    case "logged-in-required": {
                        if($behaviorValue && Identity::isGuest()) {
                            throw new Exception("Access denied");
                        }
                        break;
                    }
                }
            }
        }
    }
	
	public function render($viewName, $params = []) {
	    Request::applyHeaders();
		global $content;
        $viewName = Request::getController()."/".$viewName;
		$GLOBALS["content"] = $this->requireToVar($viewName, $params);
		$viewPath = __DIR__ . "/../views/base.php";
		require_once($viewPath);
	}

	public function renderPartial($viewName, $params = []) {
        Request::applyHeaders();
        $viewPath = __DIR__ . "/../views/".Request::getController()."/".$viewName.".php";
        if(is_array($params)) {
            foreach($params as $key => $val) {
                global ${$key};
                $GLOBALS[$key] = $val;
            }
        }
        require_once($viewPath);
    }
	
	public function redirect($action, $params = []){
        $this->controller = Request::getController();

	    if(substr_count($action, '/') >= 2) { // NOTE(Caupo 11.06.2019): Kui anname funktsioonist sisse mitte ainult viewi, vaid ka controlleri kujul /controller/actionName, siis saaks ühest controllerist teisse redirectida.
            $controllerName = ltrim($action, '/');
            $controllerName = explode("/", $action);

            if(count($controllerName) >= 2) {
                $action = $controllerName[2];
                $controllerName = $controllerName[1];
                $this->controller = $controllerName;
            }
        }

	    $urlTo = Url::to("/");

	    if($this->controller == "site" && $action == "index") {
            header("Location: $urlTo");
        } else if(isset($_SERVER["QUERY_STRING"]) && strlen($_SERVER["QUERY_STRING"]) >= 3) {
            header("Location: $urlTo{$this->controller}/{$action}?{$_SERVER['QUERY_STRING']}");
        } else if(count($params) <= 0) {
            header("Location: $urlTo{$this->controller}/{$action}");
		} else if(count($params) > 0) {
			$queryStr = "?";
			foreach ($params as $key => $value) {
				$queryStr .= "{$key}={$value}&";
			}
			$queryStr = rtrim($queryStr, "&");
			header("Location: $urlTo{$this->controller}/{$action}{$queryStr}");
		}
        exit();
	}

	public function goHome() {
        $urlTo = Url::to("/");
        header("Location: $urlTo");
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
		if(file_exists($viewPath)) {
            require_once($viewPath);
            return ob_get_clean();
        }
		return "<strong>Error: View file [{$viewName}] not found!</strong>";
	}
/**
 * USAGE: 	
 * public function actionAjax() {
 *		return $this->json(json_encode(["message" => "straight out of compton"]));
 *	}
 */
	public function json($data){
		echo $data;
	}
}

?>