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
    let semesterArr = JSON.parse('<?= json_encode(Helper::generateSemesters()) ?>');
    let degrees = JSON.parse('<?= json_encode(Helper::getDegrees()) ?>');

    let selectedDepartment = 0;

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

    function CreateElement(elementType, className, name, placeholder, value, datasetValue, elementId = "", inputType = "text") {
        let el = document.createElement(elementType);
        if(elementId.length > 0) {
            el.id = elementId;
        }
        el.type = inputType;
        el.className = className;
        if(name.length > 0) {
            el.name = name;
        }
        if(placeholder.length > 0) {
            el.placeholder = placeholder;
        }
        el.value = value;
        el.dataset.value = datasetValue;
        return el;
    }

    function CreateSelect(label, className, name, selectedValue, options) {
        if(selectedValue == undefined) {
            selectedValue = 1;
        }

        let selectBlock = document.createElement("div");

        let labelElement = document.createElement("label");
        labelElement.innerText = label;
        let select = document.createElement("select");
        select.name = name;
        select.className = className;

        for (let key in options) {
            if (options.hasOwnProperty(key)) {
                let option = document.createElement("option");
                option.value = key;
                option.innerText = options[key];
                if(key == selectedValue) {
                    option.selected = "selected";
                }
                select.appendChild(option);
            }
        }

        selectBlock.appendChild(labelElement);
        selectBlock.appendChild(select);
        return selectBlock;
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

    // CreateElement(elementType, className, name, placeholder, value, datasetValue, elementId, inputType)
    function CreateDepartmentButtons(deptId, container) {
        let departmentRemoveBtn = CreateElement("input", "btn btn-primary", "", "", "X", deptId, "department-remove-id-"+deptId, "button");
        departmentRemoveBtn.addEventListener("click", function() {
            RemoveDepartment(deptId);
        });
        container.appendChild(departmentRemoveBtn);

        let departmentViewBtn = CreateElement("input", "btn btn-primary", "", "", "Vaata instituudi erialasid", deptId, "department-view-id-"+deptId, "button");
        departmentViewBtn.addEventListener("click", function() {
            let departmentName = container.querySelector(".department-name");
            if(departmentName !== undefined && departmentName !== null) {
                GetSpeciality(deptId, departmentName.value);
                selectedDepartment = deptId;
            }
        });
        container.appendChild(departmentViewBtn);
    }

    // CreateElement(elementType, className, name, placeholder, value, datasetValue, elementId, inputType)
    function CreateDepartment(departmentId = 0, dName = "") {
        let containerId = departmentId;
        if(containerId == 0) {
            containerId = departmentCount;
        }

        let departmentContainer = document.createElement("div");
        departmentContainer.id = "department-id-"+containerId;
        let departmentNameInput = CreateElement("input", "department-name", "departmentNames[]", "Instituudi nimi", dName, departmentId);
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

    // CreateElement(elementType, className, name, placeholder, value, datasetValue)
    function CreateSpeciality(parentId = 0, inputValueName = "", inputValueDescription = "", inputValueInstruction = "", inputValueExaminations = "", inputValueDegree = "") {
        let containerId = parentId;
        let specialityContainer = document.createElement("div");
        specialityContainer.id = "speciality-id-"+containerId;
        specialityContainer.dataset.value = containerId;

        let specialityNameInput = CreateElement("input", "speciality-name", "specialityNames[]", "Eriala nimi", inputValueName, parentId);
        specialityContainer.appendChild(specialityNameInput);
        let specialityDescriptionInput = CreateElement("textarea", "speciality-description", "specialityDescription[]", "Üldinfo", inputValueDescription, parentId, "", "");
        specialityContainer.appendChild(specialityDescriptionInput);
        let specialityInstructionInput = CreateElement("textarea", "speciality-instruction", "specialityInstruction[]", "Juhised", inputValueInstruction, parentId, "", "");
        specialityContainer.appendChild(specialityInstructionInput);
        let specialityExaminationsInput = CreateElement("textarea", "speciality-examinations", "specialityExaminations[]", "Eksami materjal", inputValueExaminations, parentId, "", "");
        specialityContainer.appendChild(specialityExaminationsInput);
        let specialityDegreeInput = CreateSelect("Kraad", "speciality-degree", "specialityDegree[]", inputValueDegree, degrees);
        specialityContainer.appendChild(specialityDegreeInput);

        if(parentId > 0) {
            CreateSpecialityButtons(parentId, specialityContainer);
        }

        specialitiesContainer.appendChild(specialityContainer);

        let updateSpeciality = function() {
            if(specialityTimer !== null) {
                clearTimeout(specialityTimer);
            }
            console.log("PARENT VAL ", this.parentElement.dataset.value);
            specialityTimer = setTimeout(PostSpeciality, 500, this.parentElement.dataset.value,
                specialityNameInput, specialityDescriptionInput, specialityInstructionInput, specialityExaminationsInput, specialityDegreeInput.querySelector("select"));
        };
        specialityNameInput.addEventListener("input", updateSpeciality);
        specialityDescriptionInput.addEventListener("input", updateSpeciality);
        specialityInstructionInput.addEventListener("input", updateSpeciality);
        specialityExaminationsInput.addEventListener("input", updateSpeciality);
        specialityDegreeInput.addEventListener("input", updateSpeciality);
        specialityDegreeInput.addEventListener("change", updateSpeciality);

        specialityCount++;
    }

    function PostSpeciality(id, iName, iDesc, iInstr, iExamin, iDegree) {
        console.log("PostSpeciality: ", id, iName, iDesc, iInstr, iExamin, iDegree);

        let formData = new FormData();
        formData.append("id", id);
        formData.append("name", iName.value);
        formData.append("department_id", parseInt(selectedDepartment));
        formData.append("general_information", iDesc.value);
        formData.append("instruction", iInstr.value);
        formData.append("examinations", iExamin.value);
        formData.append("degree", parseInt(iDegree.value));

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                console.log(response.attributes.id);
                iName.dataset.value = response.attributes.id;
                iName.parentElement.dataset.value = response.attributes.id;

                if(id != iName.parentElement.dataset.value) {
                    CreateSpecialityButtons(iName.dataset.value, iName.parentElement);
                }
                console.log(iName.parentElement, "speciality-id-"+iName.dataset.value);
                iName.parentElement.id = "speciality-id-"+iName.dataset.value;
            }
        };
        xhttp.open("POST", "/speciality/save", true);
        xhttp.send(formData);
    }

    function CreateSpecialityButtons(entityId, container) {
        let specialityRemoveBtn = CreateElement("input", "btn btn-primary", "", "", "X", entityId, "speciality-remove-id-"+entityId, "button");
        specialityRemoveBtn.addEventListener("click", function() {
            RemoveSpeciality(entityId);
        });
        container.appendChild(specialityRemoveBtn);
        let studyModulesContainer = document.createElement("div");
        studyModulesContainer.id = "speciality-id-"+entityId+"-study-modules-container";

        let specialityViewBtn = CreateElement("input", "btn btn-primary", "", "", "Vaata eriala õpimooduleid", entityId, "speciality-view-id-"+entityId, "button");
        specialityViewBtn.addEventListener("click", function() {
            let specialityName = container.querySelector(".speciality-name");
            if(specialityName !== undefined && specialityName !== null) {
                GetStudyModules(entityId, studyModulesContainer);
            }
        });
        container.appendChild(specialityViewBtn);
        container.appendChild(studyModulesContainer);
    }

    function RemoveSpeciality(id) {
        let formData = new FormData();
        formData.append("id", id);

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                console.log(response);
                console.log(response.attributes.id, (response.attributes.id > 0));
                if(response.attributes.id > 0) {
                    let removeElement = document.querySelector("#speciality-id-"+response.attributes.id);
                    console.log("REMOVE ELEMENT", removeElement);
                    RemoveElement(removeElement);
                }
            }
        };
        xhttp.open("POST", "/speciality/remove", true);
        xhttp.send(formData);
    }

    // CreateElement(elementType, className, name, placeholder, value, datasetValue, elementId, inputType)
    function GetSpeciality(parentId, label) {
        clearInner(specialitiesContainer);
        let specialityHeader = document.createElement("h2");
        specialityHeader.innerText = "Instituut: "+label;
        let addSpecialityBtn = document.createElement("input");
        addSpecialityBtn.type = "button";
        addSpecialityBtn.className = "btn btn-primary";
        addSpecialityBtn.value = "Lisa eriala";
        addSpecialityBtn.addEventListener("click", function() {
            CreateSpeciality(0, "");
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
                 console.log(response.specialities[0]);

                for(let i = 0; i < response.specialities.length; i++) {
                    let spData = response.specialities[i];
                    console.log(spData);
                    CreateSpeciality(spData.attributes.id, spData.attributes.name, spData.attributes.general_information, spData.attributes.instruction, spData.attributes.examinations, spData.attributes.degree)
                }
            }
        };
        xhttp.open("POST", "/department/get-specialities", true);
        xhttp.send(formData);
    }

    /* STUDY MODULE */
    /* STUDY MODULE */
    /* STUDY MODULE */
    /* STUDY MODULE */
    /* STUDY MODULE */

    // CreateElement(elementType, className, name, placeholder, value, datasetValue, elementId, inputType)
    function CreateStudyModule(parentId, inputValue, studyModulesContainer, specialityId) {
        let containerId = parentId;
        let smContainer = document.createElement("div");
        smContainer.id = "study-module-id-"+containerId;
        smContainer.dataset.value = containerId;
        smContainer.dataset.specialityId = specialityId;

        let smNameInput = CreateElement("input", "sm-name", "smNames[]", "Õppemooduli nimi", inputValue, parentId);
        smContainer.appendChild(smNameInput);

        if(parentId > 0) {
            CreateStudyModuleButtons(parentId, smContainer);
        }

        specialitiesContainer.appendChild(smContainer);

        let updateStudyModule = function() {
            if(studyModuleTimer !== null) {
                clearTimeout(studyModuleTimer);
            }
            console.log("SM PARENT VAL ", this.parentElement.dataset.value);
            studyModuleTimer = setTimeout(PostStudyModule, 500, this.parentElement.dataset.value, smNameInput, specialityId);
        };
        smNameInput.addEventListener("input", updateStudyModule);

        studyModuleCount++;
    }

    function PostStudyModule(id, inputField, specialityId) {
        console.log("PostStudyModule: ", id, inputField);

        let formData = new FormData();
        formData.append("id", id);
        formData.append("name", inputField.value);
        formData.append("speciality_id", specialityId);

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                console.log(response.attributes.id);
                inputField.dataset.value = response.attributes.id;
                inputField.parentElement.dataset.value = response.attributes.id;

                if(id != inputField.parentElement.dataset.value) {
                    CreateStudyModuleButtons(inputField.dataset.value, inputField.parentElement, specialityId);
                }
                console.log(inputField.parentElement, "study-module-id-"+inputField.dataset.value);
                inputField.parentElement.id = "study-module-id-"+inputField.dataset.value;
            }
        };
        xhttp.open("POST", "/study-module/save", true); // TODO action
        xhttp.send(formData);
    }

    function GetStudyModules(specialityId, studyModulesContainer) {
        studyModuleCount = 0;
        clearInner(studyModulesContainer);
        let addSMBtn = document.createElement("input");
        addSMBtn.type = "button";
        addSMBtn.className = "btn btn-primary";
        addSMBtn.value = "Lisa õppemoodul";
        addSMBtn.addEventListener("click", function() {
            CreateStudyModule(0, "", studyModulesContainer, specialityId);
        });

        FetchStudyModules(specialityId, studyModulesContainer);
        studyModulesContainer.appendChild(addSMBtn);
    }

    function FetchStudyModules(specialityId, studyModulesContainer) {
        let formData = new FormData();
        formData.append("id", specialityId);

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                console.log(response);
                console.log(response.studyModules);

                for(let i = 0; i < response.studyModules.length; i++) {
                    let sm = response.studyModules[i];
                    console.log("sm", sm);
                    CreateStudyModule(sm.attributes.id, sm.attributes.name, studyModulesContainer, specialityId);
                }
            }
        };
        xhttp.open("POST", "/speciality/get-study-modules", true);
        xhttp.send(formData);
    }

    function CreateStudyModuleButtons(entityId, container) {
        let smRemoveBtn = CreateElement("input", "btn btn-primary", "", "", "X", entityId, "study-module-remove-id-"+entityId, "button");
        smRemoveBtn.addEventListener("click", function() {
            RemoveStudyModule(entityId);
        });
        container.appendChild(smRemoveBtn);
        let courseContainer = document.createElement("div");
        courseContainer.id = "study-module-id-"+entityId+"-course-container";

        let smViewBtn = CreateElement("input", "btn btn-primary", "", "", "Vaata kursuseid", entityId, "study-module-view-id-"+entityId, "button");
        smViewBtn.addEventListener("click", function() {
            let smName = container.querySelector(".speciality-name");
            if(smName !== undefined && smName !== null) {
                GetCourses(entityId, coursesContainer);
            }
        });
        container.appendChild(smViewBtn);
        container.appendChild(coursesContainer);
    }

    function RemoveStudyModule(id) {
        let formData = new FormData();
        formData.append("id", id);

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                console.log(response);
                console.log(response.attributes.id, (response.attributes.id > 0));
                if(response.attributes.id > 0) {
                    let removeElement = document.querySelector("#study-module-id-"+response.attributes.id);
                    console.log("REMOVE ELEMENT", removeElement);
                    RemoveElement(removeElement);
                }
            }
        };
        xhttp.open("POST", "/study-module/remove", true);
        xhttp.send(formData);
    }

    /* COURSE */
    /* COURSE */
    /* COURSE */
    /* COURSE */
    /* COURSE */

    // CreateElement(elementType, className, name, placeholder, value, datasetValue, elementId, inputType)
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

    // CreateElement(elementType, className, name, placeholder, value, datasetValue, elementId, inputType)
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

    // CreateElement(elementType, className, name, placeholder, value, datasetValue, elementId, inputType)
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
    textarea {
        display: block;
    }
</style>