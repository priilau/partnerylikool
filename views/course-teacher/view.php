<?php

use app\components\DetailView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Course teacher");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/course-teacher/index", "btn btn-primary") ?>

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
		[
		    "attribute" => "teacher_id",
            "value" => function($model) use ($teacher) {
				if($teacher == null) {
					return "-";
				}
                return $teacher;
            }
        ],
		'created_at'
	]
]); ?>
