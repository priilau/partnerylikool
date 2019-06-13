<?php
use app\components\ActiveForm;
use app\components\Helper;

Helper::setTitle("User");
?>

<h1><?= Helper::getTitle() ?></h1>

<h3>Login</h3>
<p>Täida väljad, et sisselogida</p>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, "username"); ?>

<?= $form->field($model, "password"); ?>

<?= ActiveForm::submitButton("Logi sisse", ["class" => "btn-success"]); ?>

<?php ActiveForm::end(); ?>