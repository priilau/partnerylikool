<?php

use app\components\GridView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Teacher");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Create", "/teacher/create", "btn btn-primary") ?>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'firstname',
		'lastname',
		'email',
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