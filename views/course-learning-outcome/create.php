<?php 

use app\components\ActiveForm;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Course learning outcome");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/course-learning-outcome/index", "btn btn-primary") ?>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'course_id')->dropDownList($options) ?>
<?= $form->field($model, 'outcome')->textarea() ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
