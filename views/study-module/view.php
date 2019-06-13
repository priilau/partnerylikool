<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("Study module");
?>

<h1><?= Helper::getTitle() ?></h1>

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
