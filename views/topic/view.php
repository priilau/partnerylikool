<?php

use app\components\DetailView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Topic");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/topic/index", "btn btn-primary") ?>
<?= Url::a("Update", "/topic/update?id=$model->id", "btn btn-primary") ?>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		'name',
		'created_by',
		'created_at'
	]
]); ?>
