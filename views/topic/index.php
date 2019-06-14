<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("Topic");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/topic/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'name',
		'created_by',
		'created_at'
	]
]); ?>