<?php

use app\components\GridView;

?>

<a class="btn btn-primary" href="/course/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'department_id',
		'study_module_id',
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