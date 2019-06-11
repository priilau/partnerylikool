<?php
use app\components\ActiveForm;
?>

<h3>Login</h3>
<p>Täida väljad, et sisselogida</p>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, "username"); ?>

<?= $form->field($model, "password"); ?>

<?= ActiveForm::submitButton("Logi sisse", ["class" => "btn-success"]); ?>

<?php ActiveForm::end(); ?>