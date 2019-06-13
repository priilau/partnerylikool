<?php 

use app\components\ActiveForm;
use app\components\Helper;

Helper::setTitle("User");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/user/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'newPassword') ?>
<?= $form->field($model, 'newPasswordConfirm') ?>

<div class="form-group">
    <?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
