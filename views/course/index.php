<?php

use app\components\GridView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Courses");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Create", "/course/create", "btn btn-primary") ?>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		[
			'attribute' => "department_id",
			'value' => function($model) use ($departmentNames){
				if(isset($departmentNames[$model->department_id])) {
					return $departmentNames[$model->department_id];
				}
				return "-";
			}
        ],
		[
			'attribute' => "study_module_id",
			'value' => function($model) use ($studyModuleNames){
				if(isset($studyModuleNames[$model->study_module_id])) {
					return $studyModuleNames[$model->study_module_id];
				}
				return "-";
			}
		],
		'code',
		'name',
		'ects',
        [
            "attribute" => "optional",
            "value" => function($model) {
                return $model->optional ? "Jah" : "Ei";
            }
        ],
		'semester',
		'contact_hours',

        [
			"attribute" => "exam",
			"value" => function($model) {
				return $model->exam ? "Jah" : "Ei";
			}
		],
		'goals',
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