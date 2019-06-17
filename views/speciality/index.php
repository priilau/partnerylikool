<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("Speciality");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/speciality/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'name',
		[
			'label' => "Department",
			'value' => function($model) use ($departmentNames){
				if(isset($departmentNames[$model->department_id])) {
					return $departmentNames[$model->department_id];
				}
			return "-";
			}
		],
		'general_information',
		'instruction',
		'examinations',
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