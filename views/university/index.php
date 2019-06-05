<?php

use app\components\GridView;

?>

<a href="/university/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		"name",
		"country"
	]
]); ?>