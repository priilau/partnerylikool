<?php

use app\components\DetailView;

?>

<a class="btn btn-primary" href="/user/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
        'id',
		'email',
        'created_at',
	]
]); ?>