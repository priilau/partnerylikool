<?php

use app\components\DetailView;

?>

<a class="btn btn-primary" href="/course-learning-outcomes/index">Back</a>

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

