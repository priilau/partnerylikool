<?php

use app\components\DetailView;

?>

<a class="btn btn-primary" href="/course/index">Back</a>
<a class="btn btn-success" href="/course/update?id=<?= $model->id ?>">Muuda</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'id',
		'department_id',
		'study_module_id',
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
