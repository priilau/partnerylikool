<?php
namespace app\controllers;

use app\components\Helper;
use app\models\Speciality;

class SiteController extends BaseController {

    public function behaviors() {
        return [
            [
                "actions" => ["admin"],
                "conditions" => [
                    "logged-in-required" => true,
                ]
            ]
        ];
    }
	
	public function actionIndex() {
        $semesters = Helper::generateSemesters();
        $degrees = Helper::getDegrees();
        $specialities = Speciality::find()->allUniqueNames();

		return $this->render("index", ["semesters" => $semesters, "degrees" => $degrees, 'specialities' => $specialities]);
	}

	public function actionAdmin() {
        return $this->render("admin");
    }
}

?>