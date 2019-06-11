<?php

use app\components\GridView;

?>

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