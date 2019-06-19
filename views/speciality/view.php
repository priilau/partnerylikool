<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("Speciality");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/speciality/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		'name',
		[
		    "attribute" => "department_id",
            "value" => function($model) use ($department) {
				if($department == null) {
					return "-";
				}
                return $department->name;
            }
        ],
		'general_information',
		'instruction',
		'examinations',
		[
		    "attribute" => "degree",
            "value" => function($model) use ($degree) {
				if($model->degree == 1){
					return "Bakalaureus";
				}
				if($model->degree == 2){
					return "Magister";
				}
				if($model->degree == 3){
					return "Doktor";
				}
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
