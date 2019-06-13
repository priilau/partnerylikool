<?php 

use app\components\ActiveForm;
use app\components\Helper;

Helper::setTitle("Speciality");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/speciality/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'department_id')->dropDownList($options) ?>
<?= $form->field($model, 'general_information') ?>
<?= $form->field($model, 'instruction') ?>
<?= $form->field($model, 'examinations') ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
