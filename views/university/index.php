<?php

use app\components\GridView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("University");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Create", "/university/create", "btn btn-primary") ?>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		"id",
		"name",
		"country",
		'contact_email', 
		'courses_available', 
        [
			"attribute" => "recommended",
			"value" => function($model) {
				return $model->recommended ? "Jah" : "Ei";
			}
		],
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