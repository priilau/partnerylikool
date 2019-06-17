<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("Departments");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/department/create">Create</a>

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