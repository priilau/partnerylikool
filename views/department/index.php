<?php

use app\components\GridView;
use app\components\QueryBuilder;
use app\models\University;

?>

<a class="btn btn-primary" href="/department/create">Create</a>

<?= GridView::widget([
	"models" => $models,
	"columns" => [
		'id',
		'name',
		[
		        'label' => "University",
		        'value' => function($model) use ($universityNames){
                    if(isset($universityNames[$model->university_id])) {
                        return $universityNames[$model->university_id];
                    }
                    return "-";
                }
        ],
		'created_by',
		'created_at'
	]
]); ?>