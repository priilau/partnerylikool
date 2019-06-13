<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("Speciality");
?>

<h1><?= Helper::getTitle() ?></h1>

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
