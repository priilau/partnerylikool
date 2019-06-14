<?php
use app\components\Identity;
use app\components\Helper;

Helper::setTitle("Adminpaneel");
?>

<h1><?= Helper::getTitle() ?></h1>

<div class="admin-link">
    <ul>
        <li><a href="/admin">Ülikoolid</a></li>
        <li><a href="/study-module">Õppemoodul</a></li>
        <li><a href="/university">Ülikoolid (eraldi kujul lisamine/muutmine)</a></li>
        <li><a href="/speciality">Erialad</a></li>
        <li><a href="/department">Instituudid</a></li>
        <li><a href="/course">Kursusesd</a></li>
        <li><a href="/course-learning-outcome">Õpiväljundid</a></li>
        <li> <a href="/course-teacher">Kursuse õpetajad</a></li>
    </ul>
</div>