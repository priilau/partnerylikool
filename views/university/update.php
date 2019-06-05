<?php 

use app\components\ActiveForm;

?>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'country') ?>
<?= $form->field($model, 'contact_email') ?>
<?= $form->field($model, 'courses_available') ?>
<?= $form->field($model, 'recommended') ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
