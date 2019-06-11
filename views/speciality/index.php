<?php

use app\components\GridView;

?>

<a class="btn btn-primary" href="/speciality/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'name',
		'department_id',
		'general_information',
		'instruction',
		'examinations',
		'created_by',
		'created_at'
	]
]); ?>