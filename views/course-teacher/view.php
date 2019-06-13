<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("Course teacher");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/course-teacher/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		'course_id',
		'teacher_id',
		'created_at'
	]
]); ?>
