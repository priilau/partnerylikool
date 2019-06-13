<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("Study module");
?>

<h1><?= Helper::getTitle() ?></h1>

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