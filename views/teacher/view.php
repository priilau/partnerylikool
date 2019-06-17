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
		[
		    "attribute" => "created_by",
            "value" => function($model) use ($user) {
				if($user == null) {
					return "-";
				}
                return $user->email;
            }
        ],
		'created_at'
	]
]); ?>
