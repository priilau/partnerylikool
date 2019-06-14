<?php 

use app\components\ActiveForm;
use app\components\Helper;

Helper::setTitle("Topic");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/topic/index">Back</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'name') ?>

<h2>Vali teemale seotud märksõnad</h2>
<div id="all-keywords">
    <?php foreach ($searchIndexes as $indexId => $keyword): ?>
        <label for="keyword-id-<?= $keyword->id ?>"><?= $keyword->keyword ?></label>
        <input class="keywords" id="keyword-id-<?= $keyword->id ?>" type="checkbox" name="searchIndex[]" value="<?= $keyword->id ?>">
    <?php endforeach; ?>
</div>

<div class="form-group">
<?= ActiveForm::submitButton("Save", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        let topicName = document.querySelector("#topic-name");
        if(topicName === null || topicName === undefined || topicName.value.length <= 0){
            alert("Teemanimi on vigane!");
            return;
        }

        let selectedKeywords = [];
        let keywords = document.querySelectorAll(".keywords");

        for(let i = 0; i < keywords.length; i++){
            if(keywords[i].checked){
                selectedKeywords.push(keywords[i].value);
            }
        }

        let formData = new FormData();
        formData.append("name", topicName.value);
        formData.append("selectedKeywords", JSON.stringify(selectedKeywords));

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                window.location.href = "/topic/view?id=<?= $model->id ?>";
            }
        };
        xhttp.open("POST", "/topic/update?id=<?= $model->id ?>", true);
        xhttp.send(formData);
        });

    
</script>