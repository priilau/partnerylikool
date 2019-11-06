<?php

use app\components\GridView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("User");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Create", "/user/create", "btn btn-primary") ?>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		"id",
        "email",
        "created_at"
	]
]); ?>