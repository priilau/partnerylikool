<?php
namespace app\controllers;

use app\config\DB;
use app\components\Helper;
use app\models\Speciality;
use app\models\Topic;
use app\models\University;

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
        $topics = Topic::find()->all();

		return $this->render("index", ["semesters" => $semesters, "degrees" => $degrees, 'specialities' => $specialities, 'topics' => $topics]);
    }
    
    public function actionSearch() {
        $topicIdsStr = "";
        $models = [];
        $data = [];
        $modelMatches = [];
        
        $selectedTopics = json_decode($_POST["selectedTopics"]); 
        if(!empty($selectedTopics)){
            foreach ($selectedTopics as $topic) {
                $topicIdsStr .= "{$topic}, ";
            }
            $topicIdsStr = rtrim($topicIdsStr, ", ");
            
            $sql = "SELECT DISTINCT university.id, university.name, university.description, university.homepage_url FROM university LEFT JOIN search_index ON university.id = search_index.university_id LEFT JOIN topic_search ON search_index.id = topic_search.search_index_id WHERE topic_id IN ({$topicIdsStr});";
            
            $mysqli = new \mysqli(DB::$host, DB::$user, DB::$pw, DB::$name);
            $stmt = $mysqli->prepare($sql); 
            if(!$stmt){
                echo $mysqli->error;
                exit("Unable to create stmt!");
            }
            $stmt->execute();
            $result = $stmt->get_result();
            
            while($row = $result->fetch_assoc()) {
                $model = new University();
                $model->load($row);
                $models[] = $model;
            }
            $stmt->close();
            $mysqli->close();
        }
        
        foreach ($models as $model) {
            $matchCount = 0;
            $keywordCount = 0;
            $uniKeywords = [];
            $modelCheck = false;

            $modelMatches[$model->id] = [
                "name" => $model->name, 
                //"icon" => $model->icon, 
                "description" => $model->description, 
                "link" => $model->homepage_url, 
                //"map" => $model->map, 
                "match" => 0
            ];
            
            $courses = $model->getCourses();
            $specialities = $model->getSpecialities();
            $searchIndexes = $model->getSearchIndexes();
            $topicSearches = $model->getTopicSearches();
            $topics = $model->getTopics();
            
            foreach ($courses as $course) {
                if($_POST["semester"] == $course->semester) {
                    $modelMatches[$model->id]["match"] += 10;
                    break;
                } else {
                    $modelCheck = true;
                    break;
                }
            }
            
            $match = false;
            $matchName = false;
            $matchPractice = false;
            
            foreach($specialities as $speciality) {
                if($_POST["degree"] == $speciality->degree && !$match) {
                    $modelMatches[$model->id]["match"] += 10;
                    $match = true;
                } else {
                    $modelCheck = true;
                    break;
                }

                if(strtolower($_POST["speciality"]) == strtolower($speciality->name) && !$matchName) {
                    $modelMatches[$model->id]["match"] += 10;
                    $matchName = true;
                } else {
                    $modelCheck = true;
                    break;
                }

                if($_POST["practice"] == $speciality->practice && !$matchPractice) {
                    $modelMatches[$model->id]["match"] += 10;
                    $matchPractice = true;
                } else {
                    $modelCheck = true;
                    break;
                }
            }  

            foreach ($searchIndexes as $searchIndex) {
                if($searchIndex->university_id == $model->id) {
                    $keywordCount++;
                    $uniKeywords[] = $searchIndex->keyword;
                }
                
                foreach ($selectedTopics as $selectedTopic) {
                    foreach ($topics as $topic) {
                        foreach ($topicSearches as $topicSearch) {
                            if(($searchIndex->id == $topicSearch->search_index_id) && ($selectedTopic == $topic->id) && ($selectedTopic == $topicSearch->topic_id)) {
                                $matchCount++;
                                break;
                            }
                        }
                    }
                }
            }

            if($keywordCount != 0) {
                $match = ($matchCount / $keywordCount) * 60;
                $modelMatches[$model->id]["match"] += $match;
            }

            if(!$modelCheck){
                $data[] = $modelMatches[$model->id];
            } else {
                unset($modelMatches[$model->id]);
            }
        }
        return $this->json(json_encode($data));
    }

	public function actionAdmin() {
        return $this->render("admin");
    }
}

?>