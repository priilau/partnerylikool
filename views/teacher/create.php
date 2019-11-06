<?php 

use app\components\ActiveForm;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Teacher");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/teacher/index", "btn btn-primary") ?>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'firstname') ?>
<?= $form->field($model, 'lastname') ?>
<?= $form->field($model, 'email') ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
