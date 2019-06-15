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
<?= $form->field($model, 'contact_email') ?>
<?= $form->field($model, 'recommended')->checkBox() ?>

<div class="content-header-block">
    <h2>Instituudid</h2>
    <input type="button" value="Lisa instituut" id="add-department-button" />
</div>

<div class="departments section-block"></div>






<div class="form-group">
<?= ActiveForm::submitButton("Salvesta", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<script>
let idCount = 0;
let departmentsContainer = document.querySelector(".departments");
let addDepartmentBtn = document.querySelector("#add-department-button");

if(addDepartmentBtn !== null && addDepartmentBtn !== undefined) {
    addDepartmentBtn.addEventListener("click", function() {
        let departmentContainer = document.createElement("div");
        let departmentElementHeader = document.createElement("h3");
        departmentElementHeader.innerText = "Instituut";

        let departmentNameInput = document.createElement("input");
        departmentNameInput.className = "department-name";
        departmentNameInput.name = "departmentNames[]";
        departmentNameInput.placeholder = "Instituudi nimi";

        /* SPECIALITIES */

        let specialitiesContainer = document.createElement("div");
        specialitiesContainer.className = "speciality-container";

        let specialityHeaderBlock = document.createElement("div");
        specialityHeaderBlock.className = "content-header-block";
        let specialities = document.createElement("div");
        specialities.className = "specialities section-block";

        let specialityHeader = document.createElement("h3");
        specialityHeader.innerText = "Erialad";
        let specialityAddBtn = document.createElement("input");
        specialityAddBtn.type = "button";
        specialityAddBtn.value = "Lisa eriala";
        specialityAddBtn.className = "add-speciality-button";
        specialityAddBtn.addEventListener("click", function() {
            let specialityContainer = document.createElement("div");
            let specialityHead = document.createElement("h4");
            specialityHead.innerText = "Eriala";
            let specialityName = document.createElement("input");
            specialityName.name = "SpecialityName[]";
            specialityName.placeholder = "Eriala nimetus";
            let specialityDescription = document.createElement("textarea");
            specialityDescription.name = "SpecialityDescription[]";
            specialityDescription.placeholder = "Üldinfo";
            let specialityInstructions = document.createElement("textarea");
            specialityInstructions.name = "SpecialityInstructions[]";
            specialityInstructions.placeholder = "Juhised";
            let specialityExamMaterial = document.createElement("textarea");
            specialityExamMaterial.name = "SpecialityExamMaterial[]";
            specialityExamMaterial.placeholder = "Eksami materjal";

            /* STUDY MODULES */

            let studyModulesContainer = document.createElement("div");
            studyModulesContainer.className = "section-block";
            let studyModuleHeaderBlock = document.createElement("div");
            studyModuleHeaderBlock.className = "content-header-block";
            let studyModulesHeader = document.createElement("h3");
            studyModulesHeader.innerText = "Õppemoodulid"
            let studyModules = document.createElement("div");
            studyModules.className = "study-modules";
            let studyModuleAddBtn = document.createElement("input");
            studyModuleAddBtn.type = "button";
            studyModuleAddBtn.value = "Lisa õppemoodul";
            studyModuleAddBtn.addEventListener("click", function() {
                let studyModule = document.createElement("div");
                studyModule.className = "study-module";
                let studyModuleElementHeader = document.createElement("h3");
                studyModuleElementHeader.innerText = "Õppemoodul";
                let studyModuleName = document.createElement("input");
                studyModuleName.type = "text";
                studyModuleName.name = "StudyModuleName[]";
                studyModuleName.placeholder = "Õppemooduli nimi";
                studyModule.appendChild(studyModuleElementHeader);
                studyModule.appendChild(studyModuleName);
                studyModules.appendChild(studyModule);

                // TODO course container -> course header block [h3 & btn] -> courses container [ainekood, aine nimi, valikaine, hindamismeetod eksam, õppeaine eesmärgid, aine kirjeldus, kontakt tundide arv]

                let courseContainer = document.createElement("div");
                courseContainer.className = "section-block";
                let courseHeaderBlock = document.createElement("div");
                courseHeaderBlock.className = "content-header-block";
                let courseHeader = document.createElement("h3");
                courseHeader.innerText = "Õppeained"
                let courses = document.createElement("div");
                courses.className = "study-modules";
                let courseAddBtn = document.createElement("input");
                courseAddBtn.type = "button";
                courseAddBtn.value = "Lisa õppeaine";
                courseAddBtn.addEventListener("click", function() {
                    let course = document.createElement("div");
                    course.className = "course";
                    let courseElementHeader = document.createElement("h3");
                    courseElementHeader.innerText = "Õppeaine";
                    let courseCode = document.createElement("input");
                    courseCode.type = "text";
                    courseCode.name = "CourseCode[]";
                    courseCode.placeholder = "Ainekood";
                    let courseName = document.createElement("input");
                    courseName.type = "text";
                    courseName.name = "CourseName[]";
                    courseName.placeholder = "Aine nimi";
                    let courseEap = document.createElement("input");
                    courseEap.type = "text";
                    courseEap.name = "CourseEap[]";
                    courseEap.placeholder = "EAP / ETCS";

                    let courseOptional = document.createElement("input");
                    courseOptional.id = "course-optional-"+idCount;
                    courseOptional.type = "checkbox";
                    courseOptional.name = "CourseOptional[]";
                    let courseOptionalLabel = document.createElement("label");
                    courseOptionalLabel.for = "course-optional-"+idCount;
                    courseOptionalLabel.innerText = "Valikaine";
                    idCount++;

                    let courseExam = document.createElement("input");
                    courseExam.id = "course-exam-"+idCount;
                    courseExam.type = "checkbox";
                    courseExam.name = "CourseExam[]";
                    let courseExamLabel = document.createElement("label");
                    courseExamLabel.for = "course-exam-"+idCount;
                    courseExamLabel.innerText = "Eksam";
                    idCount++;

                    let courseGoals = document.createElement("textarea");
                    courseGoals.name = "CourseGoal[]";
                    courseGoals.placeholder = "Õppeaine eesmärgid";

                    let courseDescription = document.createElement("textarea");
                    courseDescription.name = "CourseDescription[]";
                    courseDescription.placeholder = "Õppeaine kirjeldus";

                    let courseContactHours = document.createElement("input");
                    courseContactHours.type = "text";
                    courseContactHours.name = "CourseContactHours[]";
                    courseContactHours.placeholder = "Kontakttundide arv";

                    course.appendChild(courseElementHeader);
                    course.appendChild(courseCode);
                    course.appendChild(courseName);
                    course.appendChild(courseEap);
                    course.appendChild(courseOptional);
                    course.appendChild(courseOptionalLabel);
                    course.appendChild(document.createElement("br"));
                    course.appendChild(courseExam);
                    course.appendChild(courseExamLabel);
                    course.appendChild(document.createElement("br"));
                    course.appendChild(courseGoals);
                    course.appendChild(courseDescription);
                    course.appendChild(courseContactHours);
                    courses.appendChild(course);

                    /* TEACHERS */
                    let teachersContainer = document.createElement("div");
                    teachersContainer.className = "section-block";
                    let teachersHeaderBlock = document.createElement("div");
                    teachersHeaderBlock.className = "content-header-block";
                    let teachersHeader = document.createElement("h3");
                    teachersHeader.innerText = "Õppejõud"
                    let teachers = document.createElement("div");
                    teachers.className = "teachers";
                    let teacherAddBtn = document.createElement("input");
                    teacherAddBtn.type = "button";
                    teacherAddBtn.value = "Lisa õppejõud";
                    teacherAddBtn.addEventListener("click", function() {
                        let teacher = document.createElement("div");
                        teacher.className = "teacher"
                        let teacherName = document.createElement("input");
                        teacherName.type = "text";
                        teacherName.name = "TeacherName[]";
                        teacherName.placeholder = "Õppejõu nimi";
                        teacher.appendChild(teacherName);
                        teachers.appendChild(teacher);
                    });
                    teachersHeaderBlock.appendChild(teachersHeader);
                    teachersHeaderBlock.appendChild(teacherAddBtn);
                    teachersContainer.appendChild(teachersHeaderBlock);
                    teachersContainer.appendChild(teachers);
                    course.appendChild(teachersContainer);

                    /* OUTCOMES */

                    let outcomesContainer = document.createElement("div");
                    outcomesContainer.className = "section-block";
                    let outcomesHeaderBlock = document.createElement("div");
                    outcomesHeaderBlock.className = "content-header-block";
                    let outcomesHeader = document.createElement("h3");
                    outcomesHeader.innerText = "Õpiväljundid"
                    let outcomes = document.createElement("div");
                    outcomes.className = "outcomes";
                    let outcomeAddBtn = document.createElement("input");
                    outcomeAddBtn.type = "button";
                    outcomeAddBtn.value = "Lisa õpiväljund";
                    outcomeAddBtn.addEventListener("click", function() {
                        let outcome = document.createElement("div");
                        outcome.className = "outcome"
                        let outcomeDescription = document.createElement("textarea");
                        outcomeDescription.type = "text";
                        outcomeDescription.name = "OutcomeDescription[]";
                        outcomeDescription.placeholder = "Õpiväljundi kirjeldus";
                        outcome.appendChild(outcomeDescription);
                        outcomes.appendChild(outcome);
                    });
                    outcomesHeaderBlock.appendChild(outcomesHeader);
                    outcomesHeaderBlock.appendChild(outcomeAddBtn);
                    outcomesContainer.appendChild(outcomesHeaderBlock);
                    outcomesContainer.appendChild(outcomes);
                    course.appendChild(outcomesContainer);
                });
                courseHeaderBlock.appendChild(courseHeader);
                courseHeaderBlock.appendChild(courseAddBtn);
                courseContainer.appendChild(courseHeaderBlock);
                courseContainer.appendChild(courses);
                studyModule.appendChild(courseContainer);
            });

            studyModuleHeaderBlock.appendChild(studyModulesHeader);
            studyModuleHeaderBlock.appendChild(studyModuleAddBtn);
            studyModulesContainer.appendChild(studyModuleHeaderBlock);
            studyModulesContainer.appendChild(studyModules);

            specialityContainer.appendChild(specialityHead);
            specialityContainer.appendChild(specialityName);
            specialityContainer.appendChild(specialityDescription);
            specialityContainer.appendChild(specialityInstructions);
            specialityContainer.appendChild(specialityExamMaterial);
            specialityContainer.appendChild(studyModulesContainer);
            specialities.appendChild(specialityContainer);
        });
        specialityHeaderBlock.appendChild(specialityHeader);
        specialityHeaderBlock.appendChild(specialityAddBtn);
        specialitiesContainer.appendChild(specialityHeaderBlock);
        specialitiesContainer.appendChild(specialities);

        departmentContainer.appendChild(departmentElementHeader);
        departmentContainer.appendChild(departmentNameInput);
        departmentContainer.appendChild(specialitiesContainer);
        departmentsContainer.appendChild(departmentContainer);
    });
}
</script>

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
    }
    
    textarea {
        display: block;
    }
</style>