<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("User");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/user/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		"id",
        "email",
        "created_at"
	]
]); ?>