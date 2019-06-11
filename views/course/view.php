<?php

use app\components\DetailView;

?>

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
