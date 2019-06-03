<?php

use app\models\University;
use app\components\DetailView;
use app\components\GridView;

$model = new University();
$model->name = "Tartu Ülikool";
$model->country = "Estonia";

echo DetailView::widget([
	"model" => $model,
	"attributes" => [
		"name",
		"country"
	]
]);

$models = [];
for($i = 0; $i < 20; $i++){
	$model = new University();
	$model->name = "Tartu Ülikool ". rand(0, 100);
	$model->country = "Estonia";
	$model->id = rand(0, 100);
	$models[] = $model;
}
echo GridView::widget([
	"models" => $models,
	"columns" => [
		"name",
		"country"
	]
]);

?>