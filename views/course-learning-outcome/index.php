<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("Course learning outcome");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/course-learning-outcome/create">Create</a>

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
		'outcome',
		'created_by',
		'created_at'
	]
]); ?>