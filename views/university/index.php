<?php

use app\components\GridView;

?>

<a class="btn btn-primary" href="/university/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		"name",
		"country"
	]
]); ?>