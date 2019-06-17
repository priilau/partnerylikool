<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("Course teacher");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/course-teacher/index">Back</a>

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
