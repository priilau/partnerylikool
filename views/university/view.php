<?php

use app\components\DetailView;
use app\components\Helper;

Helper::setTitle("University");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/university/index">Back</a>

<?= DetailView::widget([
	"model" => $model,
	"attributes" => [
		'name', 
		'country', 
		'contact_email', 
		'created_at', 
		'id', 
		'courses_available', 
		'recommended', 
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
