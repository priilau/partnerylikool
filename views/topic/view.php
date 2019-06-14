<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("Topic");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/topic/index">Back</a>
<a class="btn btn-primary" href="/topic/update?id=<?= $model->id ?>">Update</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		'name',
		'created_by',
		'created_at'
	]
]); ?>
