<?php 

use app\components\ActiveForm;

?>

<a class="btn btn-primary" href="/teacher/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'firstname') ?>
<?= $form->field($model, 'lastname') ?>
<?= $form->field($model, 'email') ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
