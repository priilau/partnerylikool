<?php 

use app\components\ActiveForm;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Course teacher");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/course-teacher/index", "btn btn-primary") ?>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'course_id')->dropDownList($optionsCourse) ?>
<?= $form->field($model, 'teacher_id')->dropDownList($optionsTeacher) ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
