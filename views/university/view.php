<?php

use app\components\DetailView;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("University");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/university/index", "btn btn-primary") ?>
<?= Url::a("Update", "/university/update?id=$model->id", "btn btn-primary") ?>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'name', 
		'country', 
		'contact_email', 
		'homepage_url', 
		'map_url',
		'icon_url',
		'created_at', 
		'id', 
		'courses_available', 
        [
			"attribute" => "recommended",
			"value" => function($model) {
				return $model->recommended ? "Jah" : "Ei";
			}
		],
		[
		    "attribute" => "created_by",
            "value" => function($model) use ($user) {
				if($user == null) {
					return "-";
				}
                return $user->email;
            }
        ]
	]
]); ?>

<script>
let xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    console.log("responseText: ", this.responseText);
  }
};
xhttp.open("GET", "/university/ajax", true);
xhttp.send(); 
</script>
