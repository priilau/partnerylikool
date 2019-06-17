<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("Study module");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/study-module/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		[
		    "attribute" => "speciality_id",
            "value" => function($model) use ($speciality) {
				if($speciality == null) {
					return "-";
				}
                return $speciality->name;
            }
        ],
		'name',
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
