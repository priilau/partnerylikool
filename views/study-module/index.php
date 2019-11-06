<?php

use app\components\GridView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Study module");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Create", "/study-module/create", "btn btn-primary") ?>

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