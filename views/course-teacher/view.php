<?php

use app\components\DetailView;

?>

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
