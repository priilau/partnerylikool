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
            
            $sql = "SELECT DISTINCT university.id, university.name, university.description, university.homepage_url, university.map_url, university.icon_url FROM university LEFT JOIN search_index ON university.id = search_index.university_id LEFT JOIN topic_search ON search_index.id = topic_search.search_index_id WHERE topic_id IN ({$topicIdsStr});";
            
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
            
            $modelMatches[$model->id] = [
                "name" => $model->name, 
                "icon" => $model->icon_url, 
                "description" => $model->description, 
                "link" => $model->homepage_url, 
                "map" => $model->map_url, 
                "match" => 0
            ];
            
            $courses = $model->getCourses();
            $specialities = $model->getSpecialities();
            $searchIndexes = $model->getSearchIndexes();
            $topicSearches = $model->getTopicSearches();
            $topics = $model->getTopics();
            
            foreach ($courses as $course) {
                if($_POST["semester"] == $course->semester) {
                    $modelMatches[$model->id]["match"] += 25;
                    break;
                }
            }
            
            $matchDegree = false;
            $matchSpeciality = false;
            $matchPractice = false;
            $match = false;
            
            foreach($specialities as $speciality) {
                if($_POST["degree"] == $speciality->degree && !$matchDegree) {
                    $modelMatches[$model->id]["match"] += 10;
                    $matchDegree = true;
                }

                if(strtolower($_POST["speciality"]) == strtolower($speciality->name) && !$matchSpeciality) {
                    $modelMatches[$model->id]["match"] += 10;
                    $matchSpeciality = true;
                }

                if($_POST["practice"] == $speciality->practice && !$matchPractice) {
                    $modelMatches[$model->id]["match"] += 25;
                    $matchPractice = true;
                }
            }  

            foreach ($searchIndexes as $searchIndex) {
                if($searchIndex->university_id == $model->id) {
                    $keywordCount++;
                }
                
                foreach ($selectedTopics as $selectedTopic) {
                    foreach ($topics as $topic) {
                        foreach ($topicSearches as $topicSearch) {
                            if(($searchIndex->id == $topicSearch->search_index_id) && ($selectedTopic == $topic->id) && ($selectedTopic == $topicSearch->topic_id) && ($searchIndex->university_id == $model->id) && !$match) {
                                $matchCount++;
                                $match = true;
                            }
                        }
                    }
                }
            }

            if($keywordCount != 0) {
                $match = ($matchCount / $keywordCount) * 30;
                $modelMatches[$model->id]["match"] += $match;
            }

            if($matchDegree && $matchSpeciality && $matchPractice){
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