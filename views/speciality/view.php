<?php

use app\components\DetailView;

?>

<a class="btn btn-primary" href="/speciality/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
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
