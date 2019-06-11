<?php 

use app\components\ActiveForm;

?>

<a class="btn btn-primary" href="/speciality/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'department_id') ?>
<?= $form->field($model, 'general_information') ?>
<?= $form->field($model, 'instruction') ?>
<?= $form->field($model, 'examinations') ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
