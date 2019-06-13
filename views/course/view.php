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
		'department_id',
		'study_module_id',
		'code',
		'name',
		'ects',
        [
            "label" => "Valikuline",
            "value" => function($model) {
                return $model->optional ? "Jah" : "Ei";
            }
        ],
		'semester',
		'contact_hours',
		'exam',
		'goals',
		'description'
	]
]); ?>
