<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("Courses");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/course/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		'department_id',
		'parent_course_id',
		'code',
		'name',
		'ects',
		'optional',
		'semester',
		'contact_hours',
		'exam',
		'goals',
		'description'
	]
]); ?>
