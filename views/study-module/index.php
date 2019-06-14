<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("Study module");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/study-module/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		[
			'label' => "Speciality",
			'value' => function($model) use ($specialityNames){
				if(isset($specialityNames[$model->speciality_id])) {
					return $specialityNames[$model->speciality_id];
				}
				return "-";
			}
		],
		'name',
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