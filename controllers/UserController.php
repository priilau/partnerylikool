<?php
namespace app\controllers;

use app\models\LoginForm;
	
class UserController extends BaseController {
	
	public function actionIndex() {
		// TODO nimekirja välja kuvamine
	}

    public function actionLogin() {
        $model = new LoginForm();
	    return $this->render("login", ["model" => $model]);
    }

    public function actionLogout() {
	    // TODO väljalogimise loogika. Enne vaja ära teha süsteemne user. Logged in olek jne.
    }
}

?>