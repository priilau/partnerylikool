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
		[
			'attribute' => "created_by",
			'value' => function($model) use ($userNames){
				if(isset($userNames[$model->created_by])) {
					return $userNames[$model->created_by];
				}
				return "-";
			}	
		],
		'created_at'
	]
]); ?>