<?php

use app\components\DetailView;

?>

<a href="/university/index">Back</a>

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
		'created_by'
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
