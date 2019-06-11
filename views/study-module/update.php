<?php 

use app\components\ActiveForm;

?>

<a class="btn btn-primary" href="/study-module/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'speciality_id') ?>
<?= $form->field($model, 'name') ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
