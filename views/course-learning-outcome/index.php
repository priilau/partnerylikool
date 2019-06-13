<?php

use app\components\GridView;
use app\components\Helper;

Helper::setTitle("Course learning outcome");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/course-learning-outcome/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'course_id',
		'outcome',
		'created_by',
		'created_at'
	]
]); ?>