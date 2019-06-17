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
<div class="specialities section-block"></div>
<div class="study-modules section-block"></div>
<div class="courses section-block">
</div>


<div class="form-group">
    <?= ActiveForm::submitButton("Salvesta", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<script>
    let modelId = <?= $model->id ?>;
    let departmentsContainer = document.querySelector(".departments");
    let specialitiesContainer = document.querySelector(".specialities");
    let studyModulesContainer = document.querySelector(".study-modules");
    let coursesContainer = document.querySelector(".courses");

    let addDepartmentBtn = document.querySelector("#add-department-button");
    let addSpecialityBtn = null;
    let addStudyModuleBtn = null;
    let addCourseBtn = null;
    let addTeacherBtn = null;
    let addOutcomeBtn = null;

    let departmentTimer = null;
    let specialityTimer = null;
    let studyModuleTimer = null;
    let courseTimer = null;
    let teacherTimer = null;
    let outcomeTimer = null;

    let departmentCount = 0;
    let specialityCount = 0;
    let studyModuleCount = 0;
    let courseCount = 0;
    let teacherCount = 0;
    let outcomeCount = 0;

    if(addDepartmentBtn !== null && addDepartmentBtn !== undefined) {
        addDepartmentBtn.addEventListener("click", function() {
            CreateDepartment();
        });
    }

    function clearInner(node) {
        while (node.hasChildNodes()) {
            clear(node.firstChild);
        }
    }

    function clear(node) {
        while (node.hasChildNodes()) {
            clear(node.firstChild);
        }
        node.parentNode.removeChild(node);
    }

    function RemoveElement(removeElement) {
        if(removeElement !== undefined && removeElement !== null) {
            clearInner(removeElement);
        }
    }

    function CreateElement(elementType, className, name, placeholder, value, datasetValue) {
        let el = document.createElement(elementType);
        el.className = className;
        el.name = name;
        el.placeholder = placeholder;
        el.value = value;
        el.dataset.value = datasetValue;
        return el;
    }

    function PostDepartment(id, name, universityId, nameInput) {
        let formData = new FormData();
        formData.append("id", id);
        formData.append("name", name);
        formData.append("university_id", universityId);

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                nameInput.dataset.value = response.attributes.id;

                if(id != nameInput.dataset.value) {
                    CreateDepartmentButtons(nameInput.dataset.value, nameInput.parentElement);
                }
                console.log(nameInput.parentElement, "department-id-"+nameInput.dataset.value);
                nameInput.parentElement.id = "department-id-"+nameInput.dataset.value;
            }
        };
        xhttp.open("POST", "/department/save", true);
        xhttp.send(formData);
    }

    function RemoveDepartment(id) {
        let formData = new FormData();
        formData.append("id", id);

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                console.log(response);
                console.log(response.attributes.id, (response.attributes.id > 0));
                if(response.attributes.id > 0) {
                    let removeElement = document.querySelector("#department-id-"+response.attributes.id);
                    console.log("REMOVE ELEMENT", removeElement);
                    RemoveElement(removeElement);
                }
            }
        };
        xhttp.open("POST", "/department/remove", true);
        xhttp.send(formData);
    }

    function CreateDepartmentButtons(deptId, container) {
        let departmentRemoveBtn = document.createElement("input");
        departmentRemoveBtn.id = "department-remove-id-"+deptId;
        departmentRemoveBtn.type = "button";
        departmentRemoveBtn.className = "btn btn-primary";
        departmentRemoveBtn.value = "X";
        departmentRemoveBtn.dataset.value = deptId;
        departmentRemoveBtn.addEventListener("click", function() {
            RemoveDepartment(deptId);
        });
        container.appendChild(departmentRemoveBtn);

        let departmentViewBtn = document.createElement("input");
        departmentViewBtn.id = "department-view-id-"+deptId;
        departmentViewBtn.type = "button";
        departmentViewBtn.className = "btn btn-primary";
        departmentViewBtn.value = "Vaata instituudi erialasid";
        departmentViewBtn.dataset.value = deptId;
        departmentViewBtn.addEventListener("click", function() {
            let departmentName = container.querySelector(".department-name");
            if(departmentName !== undefined && departmentName !== null) {
                GetSpeciality(deptId, departmentName.value);
            }
        });
        container.appendChild(departmentViewBtn);
    }

    function CreateDepartment(departmentId = 0, dName = "") {
        let containerId = departmentId;
        if(containerId == 0) {
            containerId = departmentCount;
        }

        let departmentContainer = document.createElement("div");
        departmentContainer.id = "department-id-"+containerId;

        let departmentNameInput = document.createElement("input");
        departmentNameInput.className = "department-name";
        departmentNameInput.name = "departmentNames[]";
        departmentNameInput.placeholder = "Instituudi nimi";
        departmentNameInput.value = dName;
        departmentNameInput.dataset.value = departmentId;
        departmentContainer.appendChild(departmentNameInput);

        if(departmentId > 0) {
            CreateDepartmentButtons(departmentId, departmentContainer);
        }

        departmentsContainer.appendChild(departmentContainer);

        departmentNameInput.addEventListener("input", function() {
            if(departmentTimer !== null) {
                clearTimeout(departmentTimer);
            }
            departmentTimer = setTimeout(PostDepartment, 500, this.dataset.value, departmentNameInput.value, modelId, departmentNameInput);
        });

        departmentCount++;
    }

    /* SPECIALITY */
    /* SPECIALITY */
    /* SPECIALITY */
    /* SPECIALITY */
    /* SPECIALITY */

    function CreateSpeciality(parentId, inputValueName) {
        let containerId = parentId;
        if(containerId == 0) {
            containerId = specialityCount;
        }

        let specialityContainer = document.createElement("div");
        specialityContainer.id = "speciality-id-"+containerId;

        let specialityNameInput = CreateElement("input", "speciality-name", "specialityNames[]", "Eriala nimi", inputValueName, parentId);
        specialityContainer.appendChild(specialityNameInput);

        if(parentId > 0) {
            CreateSpecialityButtons(parentId, specialityContainer);
        }

        specialitiesContainer.appendChild(specialityContainer);

        specialityNameInput.addEventListener("input", function() {
            if(specialityTimer !== null) {
                clearTimeout(specialityTimer);
            }
            specialityTimer = setTimeout(PostSpeciality, 500, this.dataset.value, specialityNameInput.value, parentId, specialityNameInput);
        });

        specialityCount++;
    }

    function PostSpeciality(id, parentId, inputField, inputValue) {

    }

    function RemoveSpeciality(id) {

    }

    function GetSpeciality(parentId, label) {
        clearInner(specialitiesContainer);
        let specialityHeader = document.createElement("h2");
        specialityHeader.innerText = "Instituut: "+label;
        let addSpecialityBtn = document.createElement("input");
        addSpecialityBtn.type = "button";
        addSpecialityBtn.className = "btn btn-primary";
        addSpecialityBtn.value = "Lisa eriala";
        addSpecialityBtn.addEventListener("click", function() {
            CreateSpeciality(parentId, "");
        });

        FetchSpecialities(parentId);
        specialitiesContainer.appendChild(specialityHeader);
        specialitiesContainer.appendChild(addSpecialityBtn);
    }

    function FetchSpecialities(departmentId) {
        let formData = new FormData();
        formData.append("id", departmentId);

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                console.log(response);
                // TODO luua createElement ja append specialitiesContainer
            }
        };
        xhttp.open("POST", "/department/get-specialities", true);
        xhttp.send(formData);
    }

    function CreateSpecialityButtons(parentId, container) {

    }

    /* STUDY MODULE */
    /* STUDY MODULE */
    /* STUDY MODULE */
    /* STUDY MODULE */
    /* STUDY MODULE */

    function CreateStudyModule(parentId, inputValue) {

    }

    function PostStudyModule(id, parentId, inputField, inputValue) {

    }

    function RemoveStudyModule(id) {

    }

    function GetStudyModules(parentId) {

    }

    function CreateStudyModuleButtons(parentId, container) {

    }

    /* COURSE */
    /* COURSE */
    /* COURSE */
    /* COURSE */
    /* COURSE */

    function CreateCourse(parentId, inputValue) {

    }

    function PostCourse(id, parentId, inputField, inputValue) {

    }

    function RemoveCourse(id) {

    }

    function GetCourses(parentId) {

    }

    function CreateCourseButtons(parentId, container) {

    }

    /* TEACHER */
    /* TEACHER */
    /* TEACHER */
    /* TEACHER */
    /* TEACHER */

    function CreateTeacher(parentId, inputValue) {

    }

    function PostTeacher(id, parentId, inputField, inputValue) {

    }

    function RemoveTeacher(id) {

    }

    function GetTeachers(parentId) {

    }

    function CreateTeacherButtons(parentId, container) {

    }

    /* OUTCOME */
    /* OUTCOME */
    /* OUTCOME */
    /* OUTCOME */
    /* OUTCOME */

    function CreateOutcome(parentId, inputValue) {

    }

    function PostOutcome(id, parentId, inputField, inputValue) {

    }

    function RemoveOutcome(id) {

    }

    function GetOutcomes(parentId) {

    }

    function CreateOutcomeButtons(parentId, container) {

    }

    <?php $departments = $model->getDepartments(); ?>
    <?php foreach($departments as $department): ?>
        CreateDepartment(<?= $department->id ?>, '<?= $department->name ?>');
    <?php endforeach; ?>
</script>

<style>
    /* TODO Kristjan tõsta see pärast site.css faili. */
    .section-block {
        padding-left: 20px;
    }
</style>