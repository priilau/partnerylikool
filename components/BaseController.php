<?php
namespace app\controllers;

use app\components\Request;
	
class BaseController {

    public $controller = "site";
    public $action = "index";
	
	public function initialAction($action, $controller, $params) {
        Request::setController($controller); // NOTE(Caupo 03.06.2019): Setime Requesti kaudu globalsi kuna call_user_func_array-ga tehes ei lähe edasi baseControlleri property väärtused.
        Request::setAction($action); // NOTE(Caupo 03.06.2019): Setime Requesti kaudu globalsi kuna call_user_func_array-ga tehes ei lähe edasi baseControlleri property väärtused.
        Request::setUserAgent($_SERVER["HTTP_USER_AGENT"]);
        Request::setParams($params);
        Request::setUserIP();

        $this->action = $action;
        $this->controller = $controller;

		$action = ucfirst($action);
		$controller = ucfirst($controller);
		$controllerName = "app\controllers\\{$controller}Controller";
		$instance = new $controllerName;
		$actionName = "action{$action}";
		call_user_func_array([$instance, $actionName], $params);
	}
	
	public function render($viewName, $params = []) {
	    Request::applyHeaders();
		global $content;
        $viewName = Request::getController()."/".$viewName;
		$GLOBALS["content"] = $this->requireToVar($viewName, $params);
		$viewPath = __DIR__ . "/../views/base.php";
		require_once($viewPath);
	}
	
	public function redirect($action, $params = []){
	    $host = $_SERVER["HTTP_HOST"];
        $this->controller = Request::getController();
	    if($this->controller == "site" && $action == "index") {
            header("Location: http://{$host}/");
        } else if(isset($_SERVER["QUERY_STRING"]) && strlen($_SERVER["QUERY_STRING"]) >= 3) {
            header("Location: http://{$host}/{$this->controller}/{$action}?{$_SERVER['QUERY_STRING']}");
        } else if(count($params) <= 0) {
            header("Location: http://{$host}/{$this->controller}/{$action}");
		} else if(count($params) > 0) {
			$queryStr = "?";
			foreach ($params as $key => $value) {
				$queryStr .= "{$key}={$value}&";
			}
			$queryStr = rtrim($queryStr, "&");
			header("Location: http://{$host}/{$this->controller}/{$action}{$queryStr}");
		}
		echo 1;
		var_dump($this->controller, $action, isset($_SERVER["QUERY_STRING"]), strlen($_SERVER["QUERY_STRING"]), count($params), $params);
        exit();
	}

	public function goHome() {
        $host = $_SERVER["HTTP_HOST"];
        header("Location: http://{$host}/");
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