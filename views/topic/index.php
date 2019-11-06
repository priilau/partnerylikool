<?php

use app\components\GridView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Topic");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Create", "/topic/create", "btn btn-primary") ?>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'name',
		'created_by',
		'created_at'
	]
]); ?>