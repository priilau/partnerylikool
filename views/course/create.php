<?php

use app\components\ActiveForm;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Courses");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/course/index", "btn btn-primary") ?>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'department_id')->dropDownList($optionsDepartment) ?>
<?= $form->field($model, 'study_module_id')->dropDownList($optionsStudyModule) ?>
<?= $form->field($model, 'code') ?>
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'ects') ?>
<?= $form->field($model, 'optional')->checkBox() ?>
<?= $form->field($model, 'semester')->dropDownList(Helper::generateSemesters()) ?>
<?= $form->field($model, 'contact_hours') ?>
<?= $form->field($model, 'exam')->checkBox() ?>
<?= $form->field($model, 'goals')->textarea() ?>
<?= $form->field($model, 'description')->textarea() ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
