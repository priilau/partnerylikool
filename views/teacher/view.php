<?php

use app\components\DetailView;

?>

<a class="btn btn-primary" href="/teacher/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		'firstname',
		'lastname',
		'email',
		'created_by',
		'created_at'
	]
]); ?>
