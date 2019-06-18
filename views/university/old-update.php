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

<script>
    let idCount = 0;
    let departmentsContainer = document.querySelector(".departments");
    let addDepartmentBtn = document.querySelector("#add-department-button");
    let semesterArr = JSON.parse('<?= json_encode(Helper::generateSemesters()) ?>');
    let degrees = JSON.parse('<?= json_encode(Helper::getDegrees()) ?>');

    let lastSpecialityCont = null;
    let lastStudyModuleCont = null;
    let lastCourseCont = null;
    let lastTeachersCont = null;
    let lastOutcomesCont = null;

    let departmentCount = 1;
    let specialityCount = 0;
    let studyModuleCount = 0;
    let courseCount = 0;

    function CreateDepartment(parentId, dName = "") {
        if(parentId == 0) {
            parentId = 1;
            departmentCount = parentId;
        }
        let departmentContainer = document.createElement("div");
        let departmentElementHeader = document.createElement("h3");
        departmentElementHeader.innerText = "Instituut";

        let departmentNameInput = document.createElement("input");
        departmentNameInput.className = "department-name";
        departmentNameInput.name = "departmentNames["+parentId+"]";
        departmentNameInput.placeholder = "Instituudi nimi";
        departmentNameInput.value = dName;
        departmentContainer.appendChild(departmentElementHeader);
        departmentContainer.appendChild(departmentNameInput);

        CreateSpecialityBlock(departmentCount, departmentContainer);
        departmentsContainer.appendChild(departmentContainer);
        departmentCount++;
        return departmentContainer;
    }

    function CreateSpecialityBlock(parentId, parentDOMElement) {
        let specialitiesContainer = document.createElement("div");
        specialitiesContainer.className = "speciality-container";

        let specialityHeaderBlock = document.createElement("div");
        specialityHeaderBlock.className = "content-header-block";
        let specialities = document.createElement("div");
        specialities.className = "specialities section-block";
        lastSpecialityCont = specialities;

        let specialityHeader = document.createElement("h3");
        specialityHeader.innerText = "Erialad";
        let specialityAddBtn = document.createElement("input");
        specialityAddBtn.type = "button";
        specialityAddBtn.value = "Lisa eriala";
        specialityAddBtn.className = "btn btn-primary";
        specialityAddBtn.dataset.value = parentId;
        specialityAddBtn.addEventListener("click", function() {
            CreateSpeciality(event, specialities);
        });
        specialityHeaderBlock.appendChild(specialityHeader);
        specialityHeaderBlock.appendChild(specialityAddBtn);
        specialitiesContainer.appendChild(specialityHeaderBlock);
        specialitiesContainer.appendChild(specialities);
        parentDOMElement.appendChild(specialitiesContainer);
        specialityCount++;
        return specialities;
    }

    function CreateSpeciality(event, specialities, sName = "", sGeneralInfo = "", sInstructions = "", sExaminations = "", sDegree = 1) {
        let nestedId = GetNestedId(event);
        if(nestedId == 0) {
            nestedId = departmentCount;
            console.log(nestedId, "DEPT");
        }
        console.log(nestedId);
        let specialityContainer = document.createElement("div");
        let specialityHead = document.createElement("h4");
        specialityHead.innerText = "Eriala";
        let specialityName = document.createElement("input");
        specialityName.name = "SpecialityName["+nestedId+"]["+specialityCount+"]";
        specialityName.placeholder = "Eriala nimetus";
        specialityName.value = sName;
        let specialityDescription = document.createElement("textarea");
        specialityDescription.name = "SpecialityDescription["+nestedId+"]["+specialityCount+"]";
        specialityDescription.placeholder = "Üldinfo";
        specialityDescription.value = sGeneralInfo;
        let specialityInstructions = document.createElement("textarea");
        specialityInstructions.name = "SpecialityInstructions["+nestedId+"]["+specialityCount+"]";
        specialityInstructions.placeholder = "Juhised";
        specialityInstructions.value = sInstructions;
        let specialityExamMaterial = document.createElement("textarea");
        specialityExamMaterial.name = "SpecialityExamMaterial["+nestedId+"]["+specialityCount+"]";
        specialityExamMaterial.placeholder = "Eksami materjal";
        specialityExamMaterial.value = sExaminations;

        let specialityDegreeLabel = document.createElement("label");
        specialityDegreeLabel.innerText = "Kraad";
        let specialityDegree = document.createElement("select");
        specialityDegree.name = "SpecialityDegree["+nestedId+"]["+specialityCount+"]";

        for (let key in degrees) {
            if (degrees.hasOwnProperty(key)) {
                let option = document.createElement("option");
                option.value = key;
                option.innerText = degrees[key];

                if(key == sDegree) {
                    option.selected = "selected";
                }

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

        CreateStudyModuleBlock(specialityCount, specialityContainer);
        specialities.appendChild(specialityContainer);
    }

    function CreateStudyModuleBlock(parentId, parentDOMElement) {
        let studyModulesContainer = document.createElement("div");
        studyModulesContainer.className = "section-block";
        let studyModuleHeaderBlock = document.createElement("div");
        studyModuleHeaderBlock.className = "content-header-block";
        let studyModulesHeader = document.createElement("h3");
        studyModulesHeader.innerText = "Õppemoodulid"
        let studyModules = document.createElement("div");
        studyModules.className = "study-modules";
        lastStudyModuleCont = studyModules;
        let studyModuleAddBtn = document.createElement("input");
        studyModuleAddBtn.className = "btn btn-primary";
        studyModuleAddBtn.type = "button";
        studyModuleAddBtn.value = "Lisa õppemoodul";
        studyModuleAddBtn.dataset.value = parentId;
        studyModuleAddBtn.addEventListener("click", function() {
            CreateStudyModule(event, studyModules);
        });

        studyModuleHeaderBlock.appendChild(studyModulesHeader);
        studyModuleHeaderBlock.appendChild(studyModuleAddBtn);
        studyModulesContainer.appendChild(studyModuleHeaderBlock);
        studyModulesContainer.appendChild(studyModules);
        parentDOMElement.appendChild(studyModulesContainer);
        studyModuleCount++;
        return studyModules;
    }

    function CreateStudyModule(event, studyModules, sMName = "") {
        let nestedId = GetNestedId(event);
        if(nestedId == 0) {
            nestedId = 1;
            console.log(nestedId, "DEPT");
        }
        let studyModule = document.createElement("div");
        studyModule.className = "study-module";
        let studyModuleElementHeader = document.createElement("h3");
        studyModuleElementHeader.innerText = "Õppemoodul";
        let studyModuleName = document.createElement("input");
        studyModuleName.type = "text";
        studyModuleName.name = "StudyModuleName["+nestedId+"]["+studyModuleCount+"]";
        studyModuleName.placeholder = "Õppemooduli nimi";
        studyModuleName.value = sMName;
        studyModule.appendChild(studyModuleElementHeader);
        studyModule.appendChild(studyModuleName);
        studyModules.appendChild(studyModule);

        CreateCourseBlock(studyModuleCount, studyModules);
    }

    function CreateCourseBlock(parentId, parentDOMElement) {
        courseCount++;
        let courseContainer = document.createElement("div");
        courseContainer.className = "section-block";
        let courseHeaderBlock = document.createElement("div");
        courseHeaderBlock.className = "content-header-block";
        let courseHeader = document.createElement("h3");
        courseHeader.innerText = "Õppeained"
        let courses = document.createElement("div");
        courses.className = "study-modules";
        lastCourseCont = courses;
        let courseAddBtn = document.createElement("input");
        courseAddBtn.className = "btn btn-primary";
        courseAddBtn.type = "button";
        courseAddBtn.value = "Lisa õppeaine";
        courseAddBtn.dataset.value = parentId;
        courseAddBtn.addEventListener("click", function() {
            CreateCourse();
        });
        courseHeaderBlock.appendChild(courseHeader);
        courseHeaderBlock.appendChild(courseAddBtn);
        courseContainer.appendChild(courseHeaderBlock);
        courseContainer.appendChild(courses);
        parentDOMElement.appendChild(courseContainer);
        return courses;
    }

    function CreateCourse(event, courses, cCode = "", cName = "", cSemesterSelected = 0, cDegree = 1, cEap = 0, cOptional = 0, cExam = 0, cGoals = "", cDescription = "", cContactHours = 0) {
        let nestedId = GetNestedId(event);
        let course = document.createElement("div");
        course.className = "course";
        let courseElementHeader = document.createElement("h3");
        courseElementHeader.innerText = "Õppeaine";
        let courseCode = document.createElement("input");
        courseCode.type = "text";
        courseCode.name = "CourseCode["+nestedId+"]["+courseCount+"]";
        courseCode.placeholder = "Ainekood";
        courseCode.value = cCode;
        let courseName = document.createElement("input");
        courseName.type = "text";
        courseName.name = "CourseName["+nestedId+"]["+courseCount+"]";
        courseName.placeholder = "Aine nimi";
        courseName.value = cName;

        let courseSemesterLabel = document.createElement("label");
        courseSemesterLabel.innerText = "Semester";
        let courseSemester = document.createElement("select");
        courseSemester.name = "CourseSemester["+nestedId+"]["+courseCount+"]";
        for(let i = 0; i < semesterArr.length; i++) {
            let option = document.createElement("option");
            option.value = semesterArr[i];
            option.innerText = semesterArr[i];
            if(cSemesterSelected == semesterArr[i]) {
                option.selected = "selected";
            }
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
                if(key == cDegree) {
                    option.selected = "selected";
                }
                courseDegree.appendChild(option);
            }
        }

        let courseEap = document.createElement("input");
        courseEap.type = "text";
        courseEap.name = "CourseEap["+nestedId+"]["+courseCount+"]";
        courseEap.placeholder = "EAP / ETCS";
        courseEap.value = cEap;

        let courseOptional = document.createElement("input");
        courseOptional.id = "course-optional-"+idCount;
        courseOptional.type = "checkbox";
        courseOptional.name = "CourseOptional["+nestedId+"]["+courseCount+"]";

        if(cOptional) {
            courseOptional.checked = "checked";
        }

        let courseOptionalLabel = document.createElement("label");
        courseOptionalLabel.for = "course-optional-"+idCount;
        courseOptionalLabel.innerText = "Valikaine";
        idCount++;

        let courseExam = document.createElement("input");
        courseExam.id = "course-exam-"+idCount;
        courseExam.type = "checkbox";
        courseExam.name = "CourseExam["+nestedId+"]["+courseCount+"]";

        if(cExam) {
            courseExam.checked = "checked";
        }

        let courseExamLabel = document.createElement("label");
        courseExamLabel.for = "course-exam-"+idCount;
        courseExamLabel.innerText = "Eksam";
        idCount++;

        let courseGoals = document.createElement("textarea");
        courseGoals.name = "CourseGoal["+nestedId+"]["+courseCount+"]";
        courseGoals.placeholder = "Õppeaine eesmärgid";
        courseGoals.value = cGoals;

        let courseDescription = document.createElement("textarea");
        courseDescription.name = "CourseDescription["+nestedId+"]["+courseCount+"]";
        courseDescription.placeholder = "Õppeaine kirjeldus";
        courseDescription.value = cDescription;

        let courseContactHours = document.createElement("input");
        courseContactHours.type = "text";
        courseContactHours.name = "CourseContactHours["+nestedId+"]["+courseCount+"]";
        courseContactHours.placeholder = "Kontakttundide arv";
        courseContactHours.value = cContactHours;

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

        CreateTeacherBlock(courseCount, course);
        CreateOutcomeBlock(courseCount, course);
    }

    function CreateTeacherBlock(parentId, parentDOMElement) {
        let teachersContainer = document.createElement("div");
        teachersContainer.className = "section-block";
        let teachersHeaderBlock = document.createElement("div");
        teachersHeaderBlock.className = "content-header-block";
        let teachersHeader = document.createElement("h3");
        teachersHeader.innerText = "Õppejõud"
        let teachers = document.createElement("div");
        teachers.className = "teachers";
        lastTeachersCont = teachers;
        let teacherAddBtn = document.createElement("input");
        teacherAddBtn.className = "btn btn-primary";
        teacherAddBtn.type = "button";
        teacherAddBtn.value = "Lisa õppejõud";
        teacherAddBtn.dataset.value = parentId;
        teacherAddBtn.addEventListener("click", function() {
            CreateTeacher(event, teachers);
        });
        teachersHeaderBlock.appendChild(teachersHeader);
        teachersHeaderBlock.appendChild(teacherAddBtn);
        teachersContainer.appendChild(teachersHeaderBlock);
        teachersContainer.appendChild(teachers);
        parentDOMElement.appendChild(teachersContainer);
    }

    function CreateTeacher(event, teachers, tName = "") {
        let nestedId = GetNestedId(event);
        let teacher = document.createElement("div");
        teacher.className = "teacher";
        let teacherName = document.createElement("input");
        teacherName.type = "text";
        teacherName.name = "TeacherName["+nestedId+"][]";
        teacherName.placeholder = "Õppejõu nimi";
        teacherName.value = tName;
        teacher.appendChild(teacherName);
        teachers.appendChild(teacher);
    }

    function CreateOutcomeBlock(parentId, parentDOMElement) {
        let outcomesContainer = document.createElement("div");
        outcomesContainer.className = "section-block";
        let outcomesHeaderBlock = document.createElement("div");
        outcomesHeaderBlock.className = "content-header-block";
        let outcomesHeader = document.createElement("h3");
        outcomesHeader.innerText = "Õpiväljundid";
        let outcomes = document.createElement("div");
        outcomes.className = "outcomes";
        lastOutcomesCont = outcomes;
        let outcomeAddBtn = document.createElement("input");
        outcomeAddBtn.className = "btn btn-primary";
        outcomeAddBtn.type = "button";
        outcomeAddBtn.value = "Lisa õpiväljund";
        outcomeAddBtn.dataset.value = parentId;
        outcomeAddBtn.addEventListener("click", function() {
            CreateOutcome(event, outcomes);
        });
        outcomesHeaderBlock.appendChild(outcomesHeader);
        outcomesHeaderBlock.appendChild(outcomeAddBtn);
        outcomesContainer.appendChild(outcomesHeaderBlock);
        outcomesContainer.appendChild(outcomes);
        parentDOMElement.appendChild(outcomesContainer);
    }

    function CreateOutcome(event, outcomes, outcomeDesc = "") {
        let nestedId = GetNestedId(event);
        let outcome = document.createElement("div");
        outcome.className = "outcome";
        let outcomeDescription = document.createElement("textarea");
        outcomeDescription.type = "text";
        outcomeDescription.name = "OutcomeDescription["+nestedId+"][]";
        outcomeDescription.placeholder = "Õpiväljundi kirjeldus";
        outcomeDescription.value = outcomeDesc;
        outcome.appendChild(outcomeDescription);
        outcomes.appendChild(outcome);
    }

    function GetNestedId(event) {
        if(event == null) {
            return 0;
        }
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

    let deptCont = null;
    let specCont = null;
    let studCont = null;
    let coursCont = null;

    <?php $departments = $model->getDepartments(); ?>
    <?php foreach($departments as $department): ?>
        deptCont = CreateDepartment(departmentCount, '<?= $department->name?>');
        //specCont = CreateSpecialityBlock(departmentCount, deptCont);

        <?php $specialities = $department->getSpecialities(); ?>
        <?php foreach($specialities as $speciality): ?>
            //console.log('<?= json_encode($speciality->name) ?>');
            CreateSpeciality(null, lastSpecialityCont, '<?= $speciality->name ?>', '<?= $speciality->general_information ?>', '<?= $speciality->instruction?>', '<?= $speciality->examinations ?>', '<?= $speciality->degree ?>');

            <?php $studyModules = $speciality->getStudyModules(); ?>
            <?php foreach($studyModules as $studyModule): ?>
                console.log('<?= json_encode($studyModule->name) ?>');
                CreateStudyModule(null, lastStudyModuleCont, '<?= $studyModule->name ?>');

                <?php $courses = $studyModule->getCourses(); ?>
                <?php foreach($courses as $course): ?>
                    CreateCourse(null, lastCourseCont, '<?= $course->code ?>', '<?= $course->name ?>', '<?= $course->semester ?>', '<?= $course->degree ?>', '<?= $course->ects ?>', '<?= $course->optional ?>', '<?= $course->exam ?>', '<?= $course->goals ?>', '<?= $course->description ?>', '<?= $course->contact_hours ?>');

                    <?php $teachers = $course->getTeachers(); ?>
                    console.log('<?= json_encode($teachers) ?>');
                    <?php foreach($teachers as $teacher): ?>
                        CreateTeacher(null, lastTeachersCont, '<?= $teacher ?>');
                    <?php endforeach; ?>
                    <?php $outcomes = $course->getOutcomes(); ?>
                    console.log('<?= json_encode($outcomes) ?>');
                    <?php foreach($outcomes as $outcome): ?>
                        CreateOutcome(null, lastOutcomesCont, '<?= $outcome ?>');
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
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