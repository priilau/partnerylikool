<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("Courses");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/course/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		[
		        'label' => "Department",
		        'value' => function($model) use ($departmentNames){
                    if(isset($departmentNames[$model->department_id])) {
                        return $departmentNames[$model->department_id];
                    }
                    return "-";
                }
        ],
		[
				'label' => "Study module",
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
		'optional',
		'semester',
		'contact_hours',
		'exam',
		'goals',
		'description',
		'created_by',
		'created_at'
	]
]); ?>