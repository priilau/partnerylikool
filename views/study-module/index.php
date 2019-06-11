<?php

use app\components\GridView;

?>

<a class="btn btn-primary" href="/study-module/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'speciality_id',
		'name',
		'created_by',
		'created_at'
	]
]); ?>