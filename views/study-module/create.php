<?php 

use app\components\ActiveForm;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Study module");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/study-module/index", "btn btn-primary") ?>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'speciality_id')->dropDownList($options) ?>
<?= $form->field($model, 'name') ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
