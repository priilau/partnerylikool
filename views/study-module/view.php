<?php

use app\components\DetailView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Study module");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/study-module/index", "btn btn-primary") ?>

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
