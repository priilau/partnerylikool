<?php
use app\components\Identity;
use app\components\Helper;
use app\components\Url;

Helper::setTitle("Adminpaneel");
?>

<h1><?= Helper::getTitle() ?></h1>

<div class="admin-link">
    <ul>
        <li><?= Url::a("Ülikoolid", "/university/index") ?></li>
        <li><?= Url::a("Teemad", "/topic/index") ?></li>
    </ul>

    <br>
    <br>
    <br>
    <h2>All olevad lingid on juhuks kui ülemiste kaudu sisestamine ei tööta.</h2>
    <p>Siin olevate linkide puhul peab üks haaval eraldi vaadetes lisama erinevaid mooduleid üksteise külge. Ülikooli kande lisamiseks peab siiski sisestama ülemise lingi kaudu.<br>Lingid on järjestatud vasakult-paremale ülevalt-alla vastavalt sellele, mis moodul on mille vanem.</p>
    <ul>
        <li><?= Url::a("Instituudid", "/department/index") ?></li>
        <li><?= Url::a("Erialad", "/speciality/index") ?></li>
        <li><?= Url::a("Õppemoodulid", "/study-module/index") ?></li>
        <li><?= Url::a("Kursused", "/course/index") ?></li>
        <li><?= Url::a("Õpiväljundid", "/course-learning-outcome/index") ?></li>
        <li><?= Url::a("Kursuste õppejõud", "/course-teacher/index") ?></li>
    </ul>
</div>