<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("Teacher");
?>

<h1><?= Helper::getTitle() ?></h1>

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
