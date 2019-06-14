<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("Courses");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/course/index">Back</a>
<a class="btn btn-success" href="/course/update?id=<?= $model->id ?>">Muuda</a>

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
		'exam',
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
