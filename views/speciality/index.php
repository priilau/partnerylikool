<?php

use app\components\GridView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Speciality");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Create", "/speciality/create", "btn btn-primary") ?>

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