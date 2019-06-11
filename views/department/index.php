<?php

use app\components\GridView;

?>

<a class="btn btn-primary" href="/department/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'name',
		'university_id',
		'created_by',
		'created_at'
	]
]); ?>