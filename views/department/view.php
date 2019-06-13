<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("Departments");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/department/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		'name',
		[
		    "label" => "University",
            "value" => function($model) use ($university) {
                return $university->name;
            }
        ],
		'created_by',
		'created_at'
	]
]); ?>

