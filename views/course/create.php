<?php 

use app\components\ActiveForm;

?>

<a class="btn btn-primary" href="/course/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'department_id') ?>
<?= $form->field($model, 'parent_course_id') ?>
<?= $form->field($model, 'code') ?>
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'ects') ?>
<?= $form->field($model, 'optional') ?>
<?= $form->field($model, 'semester') ?>
<?= $form->field($model, 'contact_hours') ?>
<?= $form->field($model, 'exam') ?>
<?= $form->field($model, 'goals') ?>
<?= $form->field($model, 'description') ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
