<?php 

use app\components\ActiveForm;
use app\components\Helper;

Helper::setTitle("Topic");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/topic/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'name') ?>

<div id="selected-keywords"></div>
<div id="all-keywords">
    <?php foreach ($searchIndexes as $indexId => $keyword): ?>
        <label for="keyword-id-<?=$indexId?>"><?= $keyword->keyword ?></label>
        <input id="keyword-id-<?=$indexId?>" type="checkbox" name="searchIndex[]" value="<?= $indexId ?>">
    <?php endforeach; ?>
</div>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
