<?php

use app\components\ActiveForm;
use app\components\Helper;

Helper::setTitle("Ülikooli muutmine");
?>

<h1><?= Helper::getTitle() ?></h1>

<a class="btn btn-primary" href="/university/index">Tagasi</a>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'country')->dropDownList(Helper::getCountries(), true) ?>
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

<script>
    let idCount = 0;
    let departmentsContainer = document.querySelector(".departments");
    let addDepartmentBtn = document.querySelector("#add-department-button");
    let semesterArr = JSON.parse('<?= json_encode(Helper::generateSemesters()) ?>');
    let degrees = JSON.parse('<?= json_encode(Helper::getDegrees()) ?>');

    let departmentCount = 1;
    let specialityCount = 0;
    let studyModuleCount = 0;
    let courseCount = 0;

    function CreateDepartment(parentId) {
        departmentCount++;
        let departmentContainer = document.createElement("div");
        let departmentElementHeader = document.createElement("h3");
        departmentElementHeader.innerText = "Instituut";

        let departmentNameInput = document.createElement("input");
        departmentNameInput.className = "department-name";
        departmentNameInput.name = "departmentNames["+parentId+"]";
        departmentNameInput.placeholder = "Instituudi nimi";
        departmentContainer.appendChild(departmentElementHeader);
        departmentContainer.appendChild(departmentNameInput);

        CreateSpeciality(departmentCount, departmentContainer);
        departmentsContainer.appendChild(departmentContainer);
    }

    function CreateSpeciality(parentId, parentDOMElement) {
        specialityCount++;
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
        specialityAddBtn.className = "btn btn-primary";
        specialityAddBtn.dataset.value = parentId;
        specialityAddBtn.addEventListener("click", function() {
            let nestedId = GetNestedId(event);
            let specialityContainer = document.createElement("div");
            let specialityHead = document.createElement("h4");
            specialityHead.innerText = "Eriala";
            let specialityName = document.createElement("input");
            specialityName.name = "SpecialityName["+nestedId+"]["+specialityCount+"]";
            specialityName.placeholder = "Eriala nimetus";
            let specialityDescription = document.createElement("textarea");
            specialityDescription.name = "SpecialityDescription["+nestedId+"]["+specialityCount+"]";
            specialityDescription.placeholder = "Üldinfo";
            let specialityInstructions = document.createElement("textarea");
            specialityInstructions.name = "SpecialityInstructions["+nestedId+"]["+specialityCount+"]";
            specialityInstructions.placeholder = "Juhised";
            let specialityExamMaterial = document.createElement("textarea");
            specialityExamMaterial.name = "SpecialityExamMaterial["+nestedId+"]["+specialityCount+"]";
            specialityExamMaterial.placeholder = "Eksami materjal";

            let specialityDegreeLabel = document.createElement("label");
            specialityDegreeLabel.innerText = "Kraad";
            let specialityDegree = document.createElement("select");
            specialityDegree.name = "SpecialityDegree["+nestedId+"]["+specialityCount+"]";

            for (let key in degrees) {
                if (degrees.hasOwnProperty(key)) {
                    let option = document.createElement("option");
                    option.value = key;
                    option.innerText = degrees[key];
                    specialityDegree.appendChild(option);
                }
            }

            specialityContainer.appendChild(specialityHead);
            specialityContainer.appendChild(specialityName);
            specialityContainer.appendChild(specialityDescription);
            specialityContainer.appendChild(specialityInstructions);
            specialityContainer.appendChild(specialityExamMaterial);
            specialityContainer.appendChild(specialityDegreeLabel);
            specialityContainer.appendChild(specialityDegree);

            CreateStudyModule(specialityCount, specialityContainer)
            specialities.appendChild(specialityContainer);
        });
        specialityHeaderBlock.appendChild(specialityHeader);
        specialityHeaderBlock.appendChild(specialityAddBtn);
        specialitiesContainer.appendChild(specialityHeaderBlock);
        specialitiesContainer.appendChild(specialities);
        parentDOMElement.appendChild(specialitiesContainer);
    }

    function CreateStudyModule(parentId, parentDOMElement) {
        studyModuleCount++;
        let studyModulesContainer = document.createElement("div");
        studyModulesContainer.className = "section-block";
        let studyModuleHeaderBlock = document.createElement("div");
        studyModuleHeaderBlock.className = "content-header-block";
        let studyModulesHeader = document.createElement("h3");
        studyModulesHeader.innerText = "Õppemoodulid"
        let studyModules = document.createElement("div");
        studyModules.className = "study-modules";
        let studyModuleAddBtn = document.createElement("input");
        studyModuleAddBtn.className = "btn btn-primary";
        studyModuleAddBtn.type = "button";
        studyModuleAddBtn.value = "Lisa õppemoodul";
        studyModuleAddBtn.dataset.value = parentId;
        studyModuleAddBtn.addEventListener("click", function() {
            let nestedId = GetNestedId(event);
            let studyModule = document.createElement("div");
            studyModule.className = "study-module";
            let studyModuleElementHeader = document.createElement("h3");
            studyModuleElementHeader.innerText = "Õppemoodul";
            let studyModuleName = document.createElement("input");
            studyModuleName.type = "text";
            studyModuleName.name = "StudyModuleName["+nestedId+"]["+studyModuleCount+"]";
            studyModuleName.placeholder = "Õppemooduli nimi";
            studyModule.appendChild(studyModuleElementHeader);
            studyModule.appendChild(studyModuleName);
            studyModules.appendChild(studyModule);

            CreateCourse(studyModuleCount, studyModules);
        });

        studyModuleHeaderBlock.appendChild(studyModulesHeader);
        studyModuleHeaderBlock.appendChild(studyModuleAddBtn);
        studyModulesContainer.appendChild(studyModuleHeaderBlock);
        studyModulesContainer.appendChild(studyModules);
        parentDOMElement.appendChild(studyModulesContainer);
    }

    function CreateCourse(parentId, parentDOMElement) {
        courseCount++;
        let courseContainer = document.createElement("div");
        courseContainer.className = "section-block";
        let courseHeaderBlock = document.createElement("div");
        courseHeaderBlock.className = "content-header-block";
        let courseHeader = document.createElement("h3");
        courseHeader.innerText = "Õppeained"
        let courses = document.createElement("div");
        courses.className = "study-modules";
        let courseAddBtn = document.createElement("input");
        courseAddBtn.className = "btn btn-primary";
        courseAddBtn.type = "button";
        courseAddBtn.value = "Lisa õppeaine";
        courseAddBtn.dataset.value = parentId;
        courseAddBtn.addEventListener("click", function() {
            let nestedId = GetNestedId(event);
            let course = document.createElement("div");
            course.className = "course";
            let courseElementHeader = document.createElement("h3");
            courseElementHeader.innerText = "Õppeaine";
            let courseCode = document.createElement("input");
            courseCode.type = "text";
            courseCode.name = "CourseCode["+nestedId+"]["+courseCount+"]";
            courseCode.placeholder = "Ainekood";
            let courseName = document.createElement("input");
            courseName.type = "text";
            courseName.name = "CourseName["+nestedId+"]["+courseCount+"]";
            courseName.placeholder = "Aine nimi";

            let courseSemesterLabel = document.createElement("label");
            courseSemesterLabel.innerText = "Semester";
            let courseSemester = document.createElement("select");
            courseSemester.name = "CourseSemester["+nestedId+"]["+courseCount+"]";
            for(let i = 0; i < semesterArr.length; i++) {
                let option = document.createElement("option");
                option.value = semesterArr[i];
                option.innerText = semesterArr[i];
                courseSemester.appendChild(option);
            }
            let courseDegreeLabel = document.createElement("label");
            courseDegreeLabel.innerText = "Kraad";
            let courseDegree = document.createElement("select");
            courseDegree.name = "CourseDegree["+nestedId+"]["+courseCount+"]";

            for (let key in degrees) {
                if (degrees.hasOwnProperty(key)) {
                    let option = document.createElement("option");
                    option.value = key;
                    option.innerText = degrees[key];
                    courseDegree.appendChild(option);
                }
            }

            let courseEap = document.createElement("input");
            courseEap.type = "text";
            courseEap.name = "CourseEap["+nestedId+"]["+courseCount+"]";
            courseEap.placeholder = "EAP / ETCS";

            let courseOptional = document.createElement("input");
            courseOptional.id = "course-optional-"+idCount;
            courseOptional.type = "checkbox";
            courseOptional.name = "CourseOptional["+nestedId+"]["+courseCount+"]";
            let courseOptionalLabel = document.createElement("label");
            courseOptionalLabel.for = "course-optional-"+idCount;
            courseOptionalLabel.innerText = "Valikaine";
            idCount++;

            let courseExam = document.createElement("input");
            courseExam.id = "course-exam-"+idCount;
            courseExam.type = "checkbox";
            courseExam.name = "CourseExam["+nestedId+"]["+courseCount+"]";
            let courseExamLabel = document.createElement("label");
            courseExamLabel.for = "course-exam-"+idCount;
            courseExamLabel.innerText = "Eksam";
            idCount++;

            let courseGoals = document.createElement("textarea");
            courseGoals.name = "CourseGoal["+nestedId+"]["+courseCount+"]";
            courseGoals.placeholder = "Õppeaine eesmärgid";

            let courseDescription = document.createElement("textarea");
            courseDescription.name = "CourseDescription["+nestedId+"]["+courseCount+"]";
            courseDescription.placeholder = "Õppeaine kirjeldus";

            let courseContactHours = document.createElement("input");
            courseContactHours.type = "text";
            courseContactHours.name = "CourseContactHours["+nestedId+"]["+courseCount+"]";
            courseContactHours.placeholder = "Kontakttundide arv";

            course.appendChild(courseElementHeader);
            course.appendChild(courseCode);
            course.appendChild(courseName);
            course.appendChild(courseSemesterLabel);
            course.appendChild(courseSemester);
            course.appendChild(document.createElement("br"));
            course.appendChild(courseDegreeLabel);
            course.appendChild(courseDegree);
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

            CreateTeacher(courseCount, course);
            CreateOutcome(courseCount, course);
        });
        courseHeaderBlock.appendChild(courseHeader);
        courseHeaderBlock.appendChild(courseAddBtn);
        courseContainer.appendChild(courseHeaderBlock);
        courseContainer.appendChild(courses);
        parentDOMElement.appendChild(courseContainer);
    }

    function CreateTeacher(parentId, parentDOMElement) {
        let teachersContainer = document.createElement("div");
        teachersContainer.className = "section-block";
        let teachersHeaderBlock = document.createElement("div");
        teachersHeaderBlock.className = "content-header-block";
        let teachersHeader = document.createElement("h3");
        teachersHeader.innerText = "Õppejõud"
        let teachers = document.createElement("div");
        teachers.className = "teachers";
        let teacherAddBtn = document.createElement("input");
        teacherAddBtn.className = "btn btn-primary";
        teacherAddBtn.type = "button";
        teacherAddBtn.value = "Lisa õppejõud";
        teacherAddBtn.dataset.value = parentId;
        teacherAddBtn.addEventListener("click", function() {
            let nestedId = GetNestedId(event);
            let teacher = document.createElement("div");
            teacher.className = "teacher"
            let teacherName = document.createElement("input");
            teacherName.type = "text";
            teacherName.name = "TeacherName["+nestedId+"][]";
            teacherName.placeholder = "Õppejõu nimi";
            teacher.appendChild(teacherName);
            teachers.appendChild(teacher);
        });
        teachersHeaderBlock.appendChild(teachersHeader);
        teachersHeaderBlock.appendChild(teacherAddBtn);
        teachersContainer.appendChild(teachersHeaderBlock);
        teachersContainer.appendChild(teachers);
        parentDOMElement.appendChild(teachersContainer);
    }

    function CreateOutcome(parentId, parentDOMElement) {
        let outcomesContainer = document.createElement("div");
        outcomesContainer.className = "section-block";
        let outcomesHeaderBlock = document.createElement("div");
        outcomesHeaderBlock.className = "content-header-block";
        let outcomesHeader = document.createElement("h3");
        outcomesHeader.innerText = "Õpiväljundid";
        let outcomes = document.createElement("div");
        outcomes.className = "outcomes";
        let outcomeAddBtn = document.createElement("input");
        outcomeAddBtn.className = "btn btn-primary";
        outcomeAddBtn.type = "button";
        outcomeAddBtn.value = "Lisa õpiväljund";
        outcomeAddBtn.dataset.value = parentId;
        outcomeAddBtn.addEventListener("click", function() {
            let nestedId = GetNestedId(event);
            let outcome = document.createElement("div");
            outcome.className = "outcome";
            let outcomeDescription = document.createElement("textarea");
            outcomeDescription.type = "text";
            outcomeDescription.name = "OutcomeDescription["+nestedId+"][]";
            outcomeDescription.placeholder = "Õpiväljundi kirjeldus";
            outcome.appendChild(outcomeDescription);
            outcomes.appendChild(outcome);
        });
        outcomesHeaderBlock.appendChild(outcomesHeader);
        outcomesHeaderBlock.appendChild(outcomeAddBtn);
        outcomesContainer.appendChild(outcomesHeaderBlock);
        outcomesContainer.appendChild(outcomes);
        parentDOMElement.appendChild(outcomesContainer);
    }

    function GetNestedId(event) {
        let targetElement = event.target || event.srcElement;
        let nestedId = 0;
        if(targetElement !== null && targetElement !== undefined) {
            nestedId = targetElement.dataset.value;
        }
        return nestedId;
    }

    if(addDepartmentBtn !== null && addDepartmentBtn !== undefined) {
        addDepartmentBtn.addEventListener("click", function() {
            CreateDepartment(departmentCount);
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
        padding-left: 40px;
        border-left: 1px solid #DDD;
        border-top: 1px solid #DDD;
    }

    textarea {
        display: block;
    }
</style>