<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("Course teacher");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/course-teacher/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		[
				'label' => "Course",
				'value' => function($model) use ($courseNames){
					if(isset($courseNames[$model->course_id])) {
						return $courseNames[$model->course_id];
				}
				return "-";
			}
		],
		[
		'label' => "Teacher",
		'value' => function($model) use ($teacherNames){
			if(isset($teacherNames[$model->teacher_id])) {
				return $teacherNames[$model->teacher_id];
			}
			return "-";
		}
	],
		'created_at'
	]
]); ?>