<?php

use app\components\DetailView;

?>

<a class="btn btn-primary" href="/department/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		'name',
		'university_id',
		'created_by',
		'created_at'
	]
]); ?>

