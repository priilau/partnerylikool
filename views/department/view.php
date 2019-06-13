<?php

use app\components\DetailView;

?>

<a class="btn btn-primary" href="/department/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		'name',
		[
		    "label" => "University",
            "value" => function() use ($university) {
                return $university->name;
            }
        ],
		'created_by',
		'created_at'
	]
]); ?>

