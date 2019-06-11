<?php

use app\components\GridView;

?>

<a class="btn btn-primary" href="/user/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		"id",
        "email",
        "created_at"
	]
]); ?>