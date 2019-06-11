<?php 

use app\components\ActiveForm;

?>

<a class="btn btn-primary" href="/course-teacher/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'course_id') ?>
<?= $form->field($model, 'teacher_id') ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
