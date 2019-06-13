<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("Speciality");
?>

<h1><?= Helper::getTitle() ?></h1>

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