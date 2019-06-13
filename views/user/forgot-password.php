<?php
use app\components\ActiveForm;
use app\components\Helper;

Helper::setTitle("Parooli taastamine");
?>

<h1><?= Helper::getTitle() ?></h1>

<p>Täida väljad, et taastada parool</p>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, "username"); ?>

<?= ActiveForm::submitButton("Taasta parool", ["class" => "btn-success"]); ?>

<?php ActiveForm::end(); ?>