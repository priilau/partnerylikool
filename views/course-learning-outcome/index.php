<?php

use app\components\GridView;

?>

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