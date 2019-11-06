<?php

use app\components\DetailView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("User");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/user/index", "btn btn-primary") ?>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
        'id',
		'email',
        'created_at',
	]
]); ?>