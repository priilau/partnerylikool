<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("Course learning outcome");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/course-learning-outcome/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		'course_id',
		'outcome',
		'created_by',
		'created_at'
	]
]); ?>

