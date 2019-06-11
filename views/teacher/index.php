<?php

use app\components\GridView;

?>

<a class="btn btn-primary" href="/teacher/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'firstname',
		'lastname',
		'email',
		'created_by',
		'created_at'
	]
]); ?>