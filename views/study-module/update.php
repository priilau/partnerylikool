<?php 

use app\components\ActiveForm;
use app\components\Helper;

Helper::setTitle("Study module");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/study-module/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'speciality_id')->dropDownList($options) ?>
<?= $form->field($model, 'name') ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
