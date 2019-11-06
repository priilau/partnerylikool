<?php

use app\components\GridView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Course learning outcome");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Create", "/course-learning-outcome/create", "btn btn-primary") ?>

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