<?php 

use app\components\ActiveForm;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Departments");
?>

<h1><?= Helper::getTitle() ?></h1>

<?= Url::a("Back", "/department/index", "btn btn-primary") ?>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'university_id')->dropDownList($options) ?>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
