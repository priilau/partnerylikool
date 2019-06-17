<?php
namespace app\controllers;

use app\models\University;
use app\models\Department;
use app\models\Speciality;
use app\models\StudyModule;
use app\models\Course;
use app\models\CourseTeacher;
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
        return $this->render("index", ["models" => $models]);
    }
    public function actionIndexPartial() {
        $models = University::find()->all();
        return $this->renderPartial("index", ["models" => $models]);
    }

    public function saveUniversitySubModels($model) {
        if(isset($_POST["departmentNames"]) && is_array($_POST["departmentNames"])) {
            foreach ($_POST["departmentNames"] as $key => $departmentName) {
                $department = new Department();
                $department->name = $departmentName;
                $department->university_id = $model->id;
                $department->save();

                if(isset($_POST["SpecialityName"][$key]) && is_array($_POST["SpecialityName"][$key])) {
                    $specialityNames = $_POST["SpecialityName"][$key];
                    foreach($specialityNames as $specialityKey => $specialityName) {
                        $speciality = new Speciality();
                        $speciality->name = $specialityName;
                        $speciality->department_id = $department->id;
                        $speciality->general_information = $this->getValueFromPost("SpecialityDescription", $key, $specialityKey);
                        $speciality->instruction = $this->getValueFromPost("SpecialityInstructions", $key, $specialityKey);
                        $speciality->examinations = $this->getValueFromPost("SpecialityExamMaterial", $key, $specialityKey);
                        $speciality->degree = $this->getValueFromPost("SpecialityDegree", $key, $specialityKey, 1);
                        $speciality->save();

                        if(isset($_POST["StudyModuleName"][$specialityKey]) && is_array($_POST["StudyModuleName"][$specialityKey])) {
                            $studyModuleNames = $_POST["StudyModuleName"][$specialityKey];
                            foreach($studyModuleNames as $studyModuleKey => $studyModuleName) {
                                $studyModule = new StudyModule();
                                $studyModule->speciality_id = $speciality->id;
                                $studyModule->name = $studyModuleName;
                                $studyModule->save();

                                if(isset($_POST["CourseCode"][$studyModuleKey]) && is_array($_POST["CourseCode"][$studyModuleKey])) {
                                    $courseCodes = $_POST["CourseCode"][$studyModuleKey];
                                    foreach($courseCodes as $courseKey => $courseCode) {
                                        $course = new Course();
                                        $course->department_id = $department->id;
                                        $course->study_module_id = $studyModule->id;
                                        $course->code = $courseCode;
                                        $course->name = $this->getValueFromPost("CourseName", $studyModuleKey, $courseKey);
                                        $course->ects = $this->getValueFromPost("CourseEap", $studyModuleKey, $courseKey);
                                        $course->optional = isset($_POST["CourseOptional"][$studyModuleKey][$courseKey]) ? 1 : 0;
                                        $course->semester = $this->getValueFromPost("CourseSemester", $studyModuleKey, $courseKey, "-");
                                        $course->exam = isset($_POST["CourseExam"][$studyModuleKey][$courseKey]) ? 1 : 0;
                                        $course->contact_hours = $this->getValueFromPost("CourseContactHours", $studyModuleKey, $courseKey);
                                        $course->goals = $this->getValueFromPost("CourseGoal", $studyModuleKey, $courseKey);
                                        $course->description = $this->getValueFromPost("CourseDescription", $studyModuleKey, $courseKey);
                                        $course->degree = $this->getValueFromPost("CourseDegree", $studyModuleKey, $courseKey, 1);
                                        $course->save();

                                        if(isset($_POST["TeacherName"][$courseKey]) && is_array($_POST["TeacherName"][$courseKey])) {
                                            $teacherNames = $_POST["TeacherName"][$courseKey];

                                            foreach($teacherNames as $teacherName) {
                                                $nameParts = explode(" ", $teacherName, 2);

                                                if(is_array($nameParts) && count($nameParts) >= 2) {
                                                    $firstName = $nameParts[0];
                                                    $lastName = $nameParts[1];
                                                    $teachers = Teacher::find()->addWhere("=", "firstname", $firstName)->addWhere("=", "lastname", $lastName)->all();

                                                    if(count($teachers) > 0) {
                                                        foreach($teachers as $teacher) {
                                                            $this->addCourseTeacher($course->id, $teacher->id);
                                                        }
                                                    } else {
                                                        $teacher = new Teacher();
                                                        $teacher->firstname = $firstName;
                                                        $teacher->lastname = $lastName;
                                                        $teacher->email = "none@none.none";

                                                        if($teacher->save()) {
                                                            $this->addCourseTeacher($course->id, $teacher->id);
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        if(isset($_POST["OutcomeDescription"][$courseKey]) && is_array($_POST["OutcomeDescription"][$courseKey])) {
                                            $outcomeDescriptions = $_POST["OutcomeDescription"][$courseKey];
                                            foreach($outcomeDescriptions as $outcomeDescription) {
                                                $outcome = new CourseLearningOutcome();
                                                $outcome->course_id = $course->id;
                                                $outcome->outcome = $outcomeDescription;
                                                $outcome->save();

                                                // NOTE(Caupo 16.06.2019): Prepare for avalanche...
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
	
	public function actionCreate() {
		$model = new University();
        $modelPost = [];
		if(count($_POST) > 0) {
            $modelPost = [
                "name" => $_POST["name"],
                "country" => $_POST["country"],
                "contact_email" => $_POST["contact_email"],
                "recommended" => $_POST["recommended"],
                "homepage_url" => $_POST["homepage_url"],
            ];
        }

		if($model->load($modelPost) && $model->save()){
            $this->saveUniversitySubModels($model);
            //var_dump($_POST);die;
			return $this->redirect("view", ["id" => $model->id]);
		} else {
			return $this->render("create", ["model" => $model]);
		}
	}

	public function addCourseTeacher($courseId, $teacherId) {
        $courseTeacher = new CourseTeacher();
        $courseTeacher->course_id = $courseId;
        $courseTeacher->teacher_id = $teacherId;
        $courseTeacher->save();
    }

	public function getValueFromPost($firstIndex, $secondIndex, $thirdIndex, $defaultValue = "") {
        return isset($_POST[$firstIndex][$secondIndex][$thirdIndex]) ? $_POST[$firstIndex][$secondIndex][$thirdIndex] : $defaultValue;
    }
	
	public function actionUpdate($id) {
		$model = $this->findModel($id);
        $modelPost = [];
        if(count($_POST) > 0) {
            $modelPost = [
                "name" => $_POST["name"],
                "country" => $_POST["country"],
                "contact_email" => $_POST["contact_email"],
                "recommended" => $_POST["recommended"],
                "homepage_url" => $_POST["homepage_url"],
            ];
        }
		
		if($model->load($modelPost) && $model->save()){
		    $departments = $model->getDepartments();

		    foreach($departments as $department) { // NOTE(Caupo 16.06.2019): See omakorda kustutab ka alamelementide alamelemendid ära kuni jada lõpuni välja
		        $department->delete();
		    }

            $this->saveUniversitySubModels($model); // NOTE(Caupo 16.06.2019): ja peale delete laeme uued elemendid külge. Nii on lihtsam handlida kõikide kannete updatemist.
            //var_dump($_POST);die;
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
		$model = new University();
		$data = QueryBuilder::select(University::tableName())->addWhere("=", "id", $id)->query();
		if($model->load($data)){
			return $model;
		}
		throw new Exception("Page not found");
	}
}

?>