<?php 

use app\components\ActiveForm;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("User");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/user/index", "btn btn-primary") ?>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'newPassword') ?>
<?= $form->field($model, 'newPasswordConfirm') ?>

<div class="form-group">
    <?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
