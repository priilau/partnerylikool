<?php

use app\components\DetailView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Courses");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/course/index", "btn btn-primary") ?>
<?= Url::a("Muuda", "/course/update?id=$model->id", "btn btn-success") ?>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		[
		    "attribute" => "department_id",
            "value" => function($model) use ($department) {
				if($department == null) {
					return "-";
				}
                return $department->name;
            }
        ],
		[
		    "attribute" => "study_module_id",
            "value" => function($model) use ($studyModule) {
				if($studyModule == null) {
					return "-";
				}
                return $studyModule->name;
            }
        ],
		'code',
		'name',
		'ects',
        [
				"attribute" => "optional",
				"value" => function($model) {
					return $model->optional ? "Jah" : "Ei";
				}
        ],
		'semester',
		'contact_hours',
        [
				"attribute" => "exam",
				"value" => function($model) {
					return $model->exam ? "Jah" : "Ei";
				}
		],
		'goals',
		'description',
		'created_at',
		[
		    "attribute" => "created_by",
            "value" => function($model) use ($user) {
				if($user == null) {
					return "-";
				}
                return $user->email;
            }
        ]
	]
]); ?>
