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
		    "attribute" => "university_id",
            "value" => function($model) use ($university) {
				if($university == null) {
					return "-";
				}
                return $university->name;
            }
        ],
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

