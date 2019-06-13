<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("Course teacher");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/course-teacher/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'course_id',
		'teacher_id',
		'created_at'
	]
]); ?>