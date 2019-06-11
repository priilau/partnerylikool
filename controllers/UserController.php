<?php
namespace app\controllers;

use app\models\LoginForm;
use app\models\User;
use app\components\Identity;
use app\components\QueryBuilder;

class UserController extends BaseController {

    public function actionLogin() {
        $model = new LoginForm();
        if($model->load($_POST) && $model->login()){
            return $this->redirect("/site/admin");
        }
	    return $this->render("login", ["model" => $model]);
    }

    public function actionIndex() {
        $models = User::find()->all();
        return $this->render("index", ["models" => $models]);
    }

    public function actionCreate() {
        $model = new User();
        if($model->load($_POST) && $model->save()){
            return $this->redirect("view", ["id" => $model->id]);
        }
        return $this->render("create", ["model" => $model]);

    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if($model->load($_POST) && $model->save()){
            return $this->redirect("view", ["id" => $model->id]);
        } else {
            return $this->render("update", ["model" => $model]);
        }
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect("index");
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        return $this->render("view", ["model" => $model]);
    }

    public function findModel($id) {
        $model = new User();
        $data = QueryBuilder::select(User::tableName())->addWhere("=", "id", $id)->query();
        if($model->load($data)){
            return $model;
        }
        throw new Exception("Page not found");
    }

    public function actionLogout() {
        Identity::logout();
    }
}

?>