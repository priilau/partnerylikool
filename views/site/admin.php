<?php
use app\components\Identity;
use app\components\Helper;

Helper::setTitle("Adminpaneel");
?>

<h1><?= Helper::getTitle() ?></h1>

<div class="admin-link">
    <ul>
        <li><a href="/university">Ülikoolid</a></li>
        <li><a href="/study-module">Õppemoodulid</a></li>
        <li><a href="/speciality">Erialad</a></li>
        <li><a href="/department">Instituudid</a></li>
        <li><a href="/course">Kursused</a></li>
        <li><a href="/course-learning-outcome">Õpiväljundid</a></li>
        <li> <a href="/course-teacher">Kursuste õppejõud</a></li>
    </ul>
</div>