<?php
use app\components\Identity;
use app\components\Helper;

Helper::setTitle("Admin");
?>

<h1><?= Helper::getTitle() ?></h1>

<div class="admin-link">
    <ul>
        <li><a href="/study-module">study-module</a></li>
        <li><a href="/university">university</a></li>
        <li><a href="/speciality">speciality</a></li>
        <li><a href="/department">department</a></li>
        <li><a href="/course">course</a></li>
        <li><a href="/course-learning-outcome">course-learning-outcome</a></li>
        <li> <a href="/course-teacher">course-teacher</a></li>
    </ul>
</div>