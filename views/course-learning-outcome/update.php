<?php 

use app\components\ActiveForm;

?>

<a class="btn btn-primary" href="/course-learning-outcome/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'course_id')->dropDownList($options) ?>
<?= $form->field($model, 'outcome') ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
