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
		'created_by',
		'created_at'
	]
]); ?>