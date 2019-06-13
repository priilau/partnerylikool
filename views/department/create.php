<?php 

use app\components\ActiveForm;
use app\components\Helper;

Helper::setTitle("Departments");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/department/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'university_id')->dropDownList($options) ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
