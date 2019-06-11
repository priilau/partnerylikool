<?php

use app\components\DetailView;

?>

<a class="btn btn-primary" href="/study-module/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		'speciality_id',
		'name',
		'created_by',
		'created_at'
	]
]); ?>
