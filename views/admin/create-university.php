<?php 

use app\components\ActiveForm;
use app\components\Helper;

Helper::setTitle("University");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/university/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'country') ?>
<?= $form->field($model, 'contact_email') ?>
<?= $form->field($model, 'recommended')->checkBox() ?>

<?php // TODO siia nüüd alamosade lisamine ja kontainerid ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
