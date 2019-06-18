<?php
namespace app\controllers;

use app\models\University;
use app\models\Department;
use app\models\Speciality;
use app\models\StudyModule;
use app\models\Course;
use app\models\CourseTeacher;
use app\models\User;
use app\models\Teacher;
use app\models\CourseLearningOutcome;
use app\components\QueryBuilder;
use Exception;
	
class UniversityController extends BaseController {

	public function behaviors() {
        return [
            "logged-in-required" => true
        ];
    }

    public function actionIndex() {
        $models = University::find()->all();
        $userNames = User::find()->allNames();
        return $this->render("index", ["models" => $models, "userNames" => $userNames]);
    }
    public function actionIndexPartial() {
        $models = University::find()->all();
        return $this->renderPartial("index", ["models" => $models]);
    }
	
	public function actionCreate() {
		$model = new University();
        $modelPost = [
            "name" => "",
            "country" => "",
            "contact_email" => "info@unknown.com",
            "recommended" => 0,
            "description" => "",
            "homepage_url" => "",
        ];

		if($model->load($modelPost) && $model->save()){
			return $this->redirect("update", ["id" => $model->id]);
		} else {
            return $this->redirect("update", ["id" => $model->id]);
		}
	}

	public function addCourseTeacher($courseId, $teacherId) {
        $courseTeacher = new CourseTeacher();
        $courseTeacher->course_id = $courseId;
        $courseTeacher->teacher_id = $teacherId;
        $courseTeacher->save();
    }
	
	public function actionUpdate($id) {
		$model = $this->findModel($id);
        $modelPost = [];
        if(count($_POST) > 0) {
            $modelPost = [
                "name" => $_POST["name"],
                "country" => $_POST["country"],
                "contact_email" => $_POST["contact_email"],
				"recommended" => isset($_POST["recommended"]) ? 1 : 0,
				"description" => $_POST["description"],
                "homepage_url" => $_POST["homepage_url"],
            ];
        }
		
		if($model->load($modelPost) && $model->save()){
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
        $user = User::find()->addWhere("=", "id", $model->created_by)->one();
		return $this->render("view", ["model" => $model, "user" => $user]);
        
	}
	
	public function findModel($id) {
		$model = new University();
		$data = QueryBuilder::select(University::tableName())->addWhere("=", "id", $id)->query();
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Page not found");
	}
}

?>