<?php
use app\components\Identity;
use app\components\Helper;

Helper::setTitle("Adminpaneel");
?>

<h1><?= Helper::getTitle() ?></h1>

<div class="admin-link">
    <ul>
        <li><a href="/university">Ülikoolid</a></li>
        <li> <a href="/topic">Teemad</a></li>
    </ul>

    <br>
    <br>
    <br>
    <h2>All olevad lingid on juhuks kui ülemiste kaudu sisestamine ei tööta.</h2>
    <p>Siin olevate linkide puhul peab üks haaval eraldi vaadetes lisama erinevaid mooduleid üksteise külge. Ülikooli kande lisamiseks peab siiski sisestama ülemise lingi kaudu.<br>Lingid on järjestatud vasakult-paremale ülevalt-alla vastavalt sellele, mis moodul on mille vanem.</p>
    <ul>
        <li><a href="/department">Instituudid</a></li>
        <li><a href="/speciality">Erialad</a></li>
        <li><a href="/study-module">Õppemoodulid</a></li>
        <li><a href="/course">Kursused</a></li>
        <li><a href="/course-learning-outcome">Õpiväljundid</a></li>
        <li> <a href="/course-teacher">Kursuste õppejõud</a></li>
    </ul>
</div>