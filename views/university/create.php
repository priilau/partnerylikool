<?php 

use app\components\ActiveForm;
use app\components\Helper;
Helper::setTitle("Ülikooli lisamine");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/university/index">Tagasi</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'country')->dropDownList(Helper::getCountries(), true) ?>
<?= $form->field($model, 'description')->textarea(); ?>
<?= $form->field($model, 'contact_email') ?>
<?= $form->field($model, 'homepage_url') ?>
<?= $form->field($model, 'recommended')->checkBox() ?>

<div class="content-header-block">
    <h2>Instituudid</h2>
    <input class="btn btn-primary" type="button" value="Lisa instituut" id="add-department-button" />
</div>

<div class="departments section-block"></div>


<div class="form-group">
<?= ActiveForm::submitButton("Salvesta", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<style>
    /* TODO Kristjan tõsta see pärast site.css faili. */
    .content-header-block h2 {
        margin-top: 6px;
    }
    .content-header-block input {
        height: 30px;
    }
    .content-header-block h2, .content-header-block h3, .content-header-block input{
        display: inline-block;
        flex: 1;
    }

    .content-header-block {
        width: 100%;
        display: flex;
    }

    input[type='text'] {
        display: block;
        margin-bottom: 10px;
    }

    .section-block {
        padding: 10px;
        padding-left: 40px;
        border-left: 1px solid #DDD;
        border-top: 1px solid #DDD;
    }
    
    textarea {
        display: block;
    }
</style>