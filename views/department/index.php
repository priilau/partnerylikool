<?php

use app\components\GridView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Departments");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Create", "/department/create", "btn btn-primary") ?>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'name',
		[
		        'label' => "University",
		        'value' => function($model) use ($universityNames){
                    if(isset($universityNames[$model->university_id])) {
                        return $universityNames[$model->university_id];
                    }
                    return "-";
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