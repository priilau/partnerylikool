<?php
use app\components\ActiveForm;
use app\components\Helper;

Helper::setTitle("User");
?>

<h1><?= Helper::getTitle() ?></h1>

<h3>Login</h3>
<p>Täida väljad, et sisselogida</p>

<?php $form = ActiveForm::begin() ?>
<div class="login-area">
    <?= $form->field($model, "username"); ?>
    <?= $form->field($model, "password")->password(); ?>
</div>

<?= ActiveForm::submitButton("Logi sisse", ["class" => "btn-success"]); ?><br>
<a class="btn btn-success" href="/user/forgot-password">Unustasid parooli?</a>

<?php ActiveForm::end(); ?>