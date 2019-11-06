<?php
use app\components\ActiveForm;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("User");
?>

<h1><?= Helper::getTitle() ?></h1>

<h3>Login</h3>
<p>Täida väljad, et sisse logida</p>

<?php $form = ActiveForm::begin() ?>
<div class="login-area">
    <?= $form->field($model, "username"); ?>
    <?= $form->field($model, "password")->password(); ?>
</div>

<?= ActiveForm::submitButton("Logi sisse", ["class" => "btn-success"]); ?><br>
<?= Url::a("Unustasid parooli", "/user/forgot-password", "btn btn-primary") ?>

<?php ActiveForm::end(); ?>