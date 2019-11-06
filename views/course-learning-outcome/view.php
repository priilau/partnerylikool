<?php

use app\components\DetailView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Course learning outcome");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/course-learning-outcome/index", "btn btn-primary") ?>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		[
		    "attribute" => "course_id",
            "value" => function($model) use ($course) {
				if($course == null) {
					return "-";
				}
                return $course->name;
            }
        ],
		'outcome',
		[
		    "attribute" => "created_by",
            "value" => function($model) use ($user) {
				if($user == null) {
					return "-";
				}
                return $user->email;
            }
        ],
		'created_at'
	]
]); ?>

