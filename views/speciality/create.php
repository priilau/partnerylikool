<?php 

use app\components\ActiveForm;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Speciality");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/speciality/index", "btn btn-primary") ?>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'department_id')->dropDownList($options) ?>
<?= $form->field($model, 'general_information')->textarea() ?> 
<?= $form->field($model, 'instruction')->textarea() ?>
<?= $form->field($model, 'examinations')->textarea() ?>
<?= $form->field($model, 'degree')->dropDownList(Helper::getDegrees()) ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
