<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("User");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/user/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
        'id',
		'email',
        'created_at',
	]
]); ?>