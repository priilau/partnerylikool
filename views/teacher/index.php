<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("Teacher");
?>

<h1><?= Helper::getTitle() ?></h1>

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