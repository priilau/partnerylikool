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
<?= $form->field($model, 'map_url') ?>
<?= $form->field($model, 'icon_url') ?>
<?= $form->field($model, 'recommended')->checkBox() ?>

<div class="content-header-block">
    <h2>Instituudid</h2>
    <input class="btn btn-primary" type="button" value="Lisa instituut" id="add-department-button" />
</div>

<div class="departments section-block"></div>
<div class="specialities section-block"></div>


<div class="form-group">
    <?= ActiveForm::submitButton("Salvesta", ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<script>
    let modelId = <?= $model->id ?>;
    let departmentsContainer = document.querySelector(".departments");
    let specialitiesContainer = document.querySelector(".specialities");
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
        if(node === null) return;
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

    function RemoveEntity(id, entityName, removeUrl) {
        let formData = new FormData();
        formData.append("id", id);

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                console.log(response);
                console.log(response.attributes.id, (response.attributes.id > 0));
                if(response.attributes.id > 0) {
                    let removeElement = document.querySelector("#"+entityName+"-id-"+response.attributes.id);
                    console.log("REMOVE ELEMENT", removeElement);
                    RemoveElement(removeElement);
                }
            }
        };
        xhttp.open("POST", removeUrl, true);
        xhttp.send(formData);
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
        if(inputType == "checkbox" && value){
            el.checked = "checked";
        } else {
            el.value = value;
        }
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
        RemoveEntity(id, "department", "/department/remove");
    }

    // CreateElement(elementType, className, name, placeholder, value, datasetValue, elementId, inputType)
    function CreateDepartmentButtons(deptId, container) {
        let departmentRemoveBtn = CreateElement("input", "btn btn-success", "", "", "X", deptId, "department-remove-id-"+deptId, "button");
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
            departmentTimer = setTimeout(PostDepartment, 300, this.dataset.value, departmentNameInput.value, modelId, departmentNameInput);
        });

        departmentCount++;
    }

    /* SPECIALITY */
    /* SPECIALITY */
    /* SPECIALITY */
    /* SPECIALITY */
    /* SPECIALITY */

    // CreateElement(elementType, className, name, placeholder, value, datasetValue)
    function CreateSpeciality(parentId = 0, inputValueName = "", inputValueDescription = "", inputValueInstruction = "", inputValueExaminations = "", inputValueDegree = "", inputValuePractice = 0) {
        let containerId = parentId;
        let specialityContainer = document.createElement("div");
        specialityContainer.id = "speciality-id-"+containerId;
        specialityContainer.className = "section-block";
        specialityContainer.dataset.value = containerId;

        let headerEl = document.createElement("h3");
        headerEl.innerText = "Eriala:";
        specialityContainer.appendChild(headerEl);
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
        let specialityPracticeLabel = document.createElement("label");
        specialityPracticeLabel.innerText = "Välispraktika";
        let specialityPracticeInput = CreateElement("input", "speciality-practice", "specialityPractice[]", "", inputValuePractice, parentId, "", "checkbox");
        specialityContainer.appendChild(specialityPracticeInput);
        specialityContainer.appendChild(specialityPracticeLabel);

        let specialityStudyModulesContainer = document.createElement("div");
        specialityStudyModulesContainer.id = "speciality-id-"+parentId+"-study-modules";
        specialityStudyModulesContainer.className = "speciality-study-modules";

        console.log("SPECIALITY CONTINER");
        console.log(specialityContainer);
        specialityContainer.appendChild(specialityStudyModulesContainer);

        if(parentId > 0) {
            CreateSpecialityButtons(parentId, specialityContainer);
        }

        specialitiesContainer.appendChild(specialityContainer);

        let updateSpeciality = function() {
            if(specialityTimer !== null) {
                clearTimeout(specialityTimer);
            }
            console.log("PARENT VAL ", this.parentElement.dataset.value);
            specialityTimer = setTimeout(PostSpeciality, 300, this.parentElement.dataset.value,
                specialityNameInput, specialityDescriptionInput, specialityInstructionInput, specialityExaminationsInput, specialityDegreeInput.querySelector("select"), specialityPracticeInput);
        };
        specialityNameInput.addEventListener("input", updateSpeciality);
        specialityDescriptionInput.addEventListener("input", updateSpeciality);
        specialityInstructionInput.addEventListener("input", updateSpeciality);
        specialityExaminationsInput.addEventListener("input", updateSpeciality);
        specialityDegreeInput.addEventListener("input", updateSpeciality);
        specialityDegreeInput.addEventListener("change", updateSpeciality);
        specialityPracticeInput.addEventListener("click", updateSpeciality);

        specialityCount++;
    }

    function PostSpeciality(id, iName, iDesc, iInstr, iExamin, iDegree, iPractice) {
        console.log("PostSpeciality: ", id, iName, iDesc, iInstr, iExamin, iDegree, iPractice);

        let formData = new FormData();
        formData.append("id", id);
        formData.append("name", iName.value);
        formData.append("department_id", parseInt(selectedDepartment));
        formData.append("general_information", iDesc.value);
        formData.append("instruction", iInstr.value);
        formData.append("examinations", iExamin.value);
        formData.append("degree", parseInt(iDegree.value));
        formData.append("practice", (iPractice.checked) ? 1 : 0);

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
        let specialityRemoveBtn = CreateElement("input", "btn btn-success", "", "", "X", entityId, "speciality-remove-id-"+entityId, "button");
        specialityRemoveBtn.addEventListener("click", function() {
            RemoveSpeciality(entityId);
        });
        container.appendChild(specialityRemoveBtn);

        let specialityViewBtn = CreateElement("input", "btn btn-primary", "", "", "Vaata eriala õpimooduleid", entityId, "speciality-view-id-"+entityId, "button");
        specialityViewBtn.addEventListener("click", function() {
            let specialityName = container.querySelector(".speciality-name");
            if(specialityName !== undefined && specialityName !== null) {
                let studyModulesContainer = document.querySelector("#speciality-id-"+entityId+" .speciality-study-modules");
                console.log("SM CONT", "#speciality-id-"+entityId+" .speciality-study-modules", studyModulesContainer);
                GetStudyModules(entityId, studyModulesContainer);
                container.appendChild(studyModulesContainer);
            }
        });
        container.appendChild(specialityViewBtn);
    }

    function RemoveSpeciality(id) {
        RemoveEntity(id, "speciality", "/speciality/remove");
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
                    CreateSpeciality(spData.attributes.id, spData.attributes.name, spData.attributes.general_information, spData.attributes.instruction, spData.attributes.examinations, spData.attributes.degree, spData.attributes.practice);
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

        let headerEl = document.createElement("h3");
        headerEl.innerText = "Õppemoodul:";
        smContainer.appendChild(headerEl);
        let smNameInput = CreateElement("input", "sm-name", "smNames[]", "Õppemooduli nimi", inputValue, parentId);
        smContainer.appendChild(smNameInput);

        if(parentId > 0) {
            CreateStudyModuleButtons(parentId, smContainer);
        }

        studyModulesContainer.appendChild(smContainer);

        let updateStudyModule = function() {
            if(studyModuleTimer !== null) {
                clearTimeout(studyModuleTimer);
            }
            console.log("SM PARENT VAL ", this.parentElement.dataset.value);
            studyModuleTimer = setTimeout(PostStudyModule, 300, this.parentElement.dataset.value, smNameInput, specialityId);
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
        xhttp.open("POST", "/study-module/save", true);
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
        specialitiesContainer.appendChild(studyModulesContainer);
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
        let smRemoveBtn = CreateElement("input", "btn btn-success", "", "", "X", entityId, "study-module-remove-id-"+entityId, "button");
        smRemoveBtn.addEventListener("click", function() {
            RemoveStudyModule(entityId);
        });
        container.appendChild(smRemoveBtn);
        let courseContainer = document.createElement("div");
        courseContainer.id = "study-module-id-"+entityId+"-courses-container";
        courseContainer.className = "section-block";

        let smViewBtn = CreateElement("input", "btn btn-primary", "", "", "Vaata kursuseid", entityId, "study-module-view-id-"+entityId, "button");
        smViewBtn.addEventListener("click", function() {
            let smName = container.querySelector(".sm-name");
            if(smName !== undefined && smName !== null) {
                GetCourses(entityId, courseContainer);
            }
        });
        container.appendChild(smViewBtn);
        container.appendChild(courseContainer);
    }

    function RemoveStudyModule(id) {
        RemoveEntity(id, "study-module", "/study-module/remove");
    }

    /* COURSE */
    /* COURSE */
    /* COURSE */
    /* COURSE */
    /* COURSE */

    function GetCourses(studyModulesId, coursesContainer) {
        console.log("GetCourses", 1);
        courseCount = 0;
        clearInner(coursesContainer);
        let addCourseBtn = document.createElement("input");
        addCourseBtn.type = "button";
        addCourseBtn.className = "btn btn-primary";
        addCourseBtn.value = "Lisa õppeaine";
        addCourseBtn.addEventListener("click", function() {
            CreateCourse(0, coursesContainer, studyModulesId, "");
        });
        console.log("GetCourses", 2);

        FetchCourses(studyModulesId, coursesContainer);
        console.log("GetCourses", 3);
        coursesContainer.appendChild(addCourseBtn);
        console.log("GetCourses", 4, coursesContainer);
    }

    // CreateElement(elementType, className, name, placeholder, value, datasetValue, elementId, inputType)
    function CreateCourse(parentId, coursesContainer, studyModuleId, iCodeVal = "", iNameVal = "", iEctsVal = 0, iGoalsVal = "", iDescriptionVal = "", iContactHours = 0, iDegreeVal = 1, iSemesterVal = 0, iOptional = 0, iExam = 0) {
        let containerId = parentId;
        let courseContainer = document.createElement("div");
        courseContainer.id = "course-id-"+containerId;
        courseContainer.dataset.value = containerId;
        courseContainer.dataset.studyModuleId = studyModuleId;

        let headerEl = document.createElement("h3");
        headerEl.innerText = "Õppeaine:";
        courseContainer.appendChild(headerEl);
        let courseCodeInput = CreateElement("input", "course-code", "courseCodes[]", "Õppeaine kood", iCodeVal, parentId);
        courseContainer.appendChild(courseCodeInput);
        let courseNameInput = CreateElement("input", "course-name", "courseNames[]", "Õppeaine nimi", iNameVal, parentId);
        courseContainer.appendChild(courseNameInput);
        let courseEctsInput = CreateElement("input", "course-ects", "courseEcts[]", "EAP", iEctsVal, parentId);
        courseContainer.appendChild(courseEctsInput);
        let courseGoalsInput = CreateElement("input", "course-goals", "courseGoals[]", "Eesmärgid", iGoalsVal, parentId);
        courseContainer.appendChild(courseGoalsInput);
        let courseDescriptionInput = CreateElement("input", "course-description", "courseDescription[]", "Kirjeldus", iDescriptionVal, parentId);
        courseContainer.appendChild(courseDescriptionInput);
        let courseContactHoursInput = CreateElement("input", "course-contact_hours", "courseContactHours[]", "Kontakttunnid", iContactHours, parentId);
        courseContainer.appendChild(courseContactHoursInput);

        let courseDegreeInput = CreateSelect("Kraad", "course-degree", "courseDegree[]", iDegreeVal, degrees);
        courseContainer.appendChild(courseDegreeInput);

        let courseSemesterInput = CreateSelect("Semester", "course-semester", "courseSemester[]", iSemesterVal, semesterArr);
        courseContainer.appendChild(courseSemesterInput);

        let courseOptionalInput = CreateElement("input", "course-optional", "courseOptional[]", "Valikaine", iOptional, parentId, "", "checkbox");
        let courseOptionalLabel = document.createElement("label");
        courseOptionalLabel.innerText = "Valikaine";
        courseContainer.appendChild(courseOptionalInput);
        courseContainer.appendChild(courseOptionalLabel);

        let courseExamInput = CreateElement("input", "course-exam", "courseExam[]", "Eksam", iExam, parentId, "", "checkbox");
        let courseExamLabel = document.createElement("label");
        courseExamLabel.innerText = "Eksam";
        courseContainer.appendChild(courseExamInput);
        courseContainer.appendChild(courseExamLabel);

        if(parentId > 0) {
            CreateCourseButtons(parentId, courseContainer, coursesContainer);
        }
        console.log("COURSES JA COURSE CONTROLLER");
        console.log(coursesContainer);
        console.log(courseContainer);
        coursesContainer.appendChild(courseContainer);

        let updateCallback = function() { if(courseTimer !== null) { clearTimeout(courseTimer); }
            courseTimer = setTimeout(PostCourse, 300, this.parentElement.dataset.value, studyModuleId,
                courseCodeInput, courseNameInput, courseEctsInput, courseGoalsInput, courseDescriptionInput, courseContactHoursInput, courseDegreeInput, courseSemesterInput, courseOptionalInput, courseExamInput);
        };
        courseCodeInput.addEventListener("input", updateCallback);
        courseNameInput.addEventListener("input", updateCallback);
        courseEctsInput.addEventListener("input", updateCallback);
        courseGoalsInput.addEventListener("input", updateCallback);
        courseDescriptionInput.addEventListener("input", updateCallback);
        courseContactHoursInput.addEventListener("input", updateCallback);
        courseDegreeInput.addEventListener("input", updateCallback);
        courseSemesterInput.addEventListener("input", updateCallback);
        courseExamInput.addEventListener("click", updateCallback);
        courseOptionalInput.addEventListener("click", updateCallback);

        courseCount++;
    }

    function CreateCourseButtons(entityId, container, coursesContainer) {
        let RemoveBtn = CreateElement("input", "btn btn-success", "", "", "X", entityId, "course-remove-id-"+entityId, "button");
        RemoveBtn.addEventListener("click", function() { RemoveCourse(entityId); });
        container.appendChild(RemoveBtn);
        let subEntityContainer = document.createElement("div");
        subEntityContainer.id = "course-id-"+entityId+"-course-teacher-container";
        // NOTE(Priit 20.06.19): Projekti aeg sai otsa, alamelementide lisamine jätkata siit
        /* 
        let viewBtn = CreateElement("input", "btn btn-primary", "", "", "Vaata õpetajaid", entityId, "teacher-view-id-"+entityId, "button");
        viewBtn.addEventListener("click", function() {
            let NameInput = container.querySelector(".course-name");
            if(NameInput !== undefined && NameInput !== null) {
                GetTeachers(entityId, coursesContainer); // TODO välja selgitada container mis siia peab tegelt minema.
            }
        });
        container.appendChild(viewBtn);

        let outcomesViewBtn = CreateElement("input", "btn btn-primary", "", "", "Vaata väljundeid", entityId, "outcomes-view-id-"+entityId, "button");
        outcomesViewBtn.addEventListener("click", function() {
            let NameInput = container.querySelector(".course-name");
            if(NameInput !== undefined && NameInput !== null) {
                GetOutcomes(entityId, coursesContainer); // TODO välja selgitada container mis siia peab tegelt minema.
            }
        });
        container.appendChild(outcomesViewBtn);
        */ 
    }

    function PostCourse(id, studyModuleId, iCode, iName, iEcts, iGoals, iDescription, iContactHours, iDegree, iSemester, iOptional, iExam) {
        console.log("PostCourse: ", id, studyModuleId, iDegree, iSemester);

        let formData = new FormData();
        formData.append("id", id);
        formData.append("study_module_id", studyModuleId);
        formData.append("department_id", parseInt(selectedDepartment));
        formData.append("code", iCode.value);
        formData.append("name", iName.value);
        formData.append("ects", iEcts.value);
        formData.append("goals", iGoals.value);
        formData.append("description", iDescription.value);
        formData.append("contact_hours", iContactHours.value);
        formData.append("degree", iDegree.querySelector("select").value);
        formData.append("semester", iSemester.querySelector("select").value);
        formData.append("optional", (iOptional.checked) ? 1 : 0);
        formData.append("exam", (iExam.checked) ? 1 : 0);

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                console.log(response.attributes.id);
                iName.dataset.value = response.attributes.id;
                iName.parentElement.dataset.value = response.attributes.id;

                if(id != iName.parentElement.dataset.value) {
                    CreateCourseButtons(iName.dataset.value, iName.parentElement, specialityId);
                }
                console.log(iName.parentElement, "course-id-"+iName.dataset.value);
                iName.parentElement.id = "course-id-"+iName.dataset.value;
            }
        };
        xhttp.open("POST", "/course/save", true);
        xhttp.send(formData);
    }

    function FetchCourses(studyModulesId, coursesContainer) {
        let formData = new FormData();
        formData.append("id", studyModulesId);

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                console.log(coursesContainer);

                for(let i = 0; i < response.courses.length; i++) {
                    let course = response.courses[i];
                    console.log("course", course);
                    CreateCourse(course.attributes.id, coursesContainer, studyModulesId, course.attributes.code, course.attributes.name, course.attributes.etcs,
                        course.attributes.goals, course.attributes.description, course.attributes.contact_hours, course.attributes.degree, course.attributes.semester, course.attributes.optional, course.attributes.exam);
                }
            }
        };
        xhttp.open("POST", "/study-module/get-courses", true);
        xhttp.send(formData);
    }

    function RemoveCourse(id) {
        RemoveEntity(id, "course", "/course/remove");
    }

    /* TEACHER */
    /* TEACHER */
    /* TEACHER */
    /* TEACHER */
    /* TEACHER */

    function GetTeachers(parentId) {

    }

    // CreateElement(elementType, className, name, placeholder, value, datasetValue, elementId, inputType)
    function CreateTeacher(parentId, inputValue, teachersContainer, courseId) {

    }

    function CreateTeacherButtons(parentId, container) {

    }

    function PostTeacher(id, parentId, inputField, inputValue) {

    }

    function RemoveTeacher(id) {
        RemoveEntity(id, "course-teacher", "/course-teacher/remove");
    }

    /* OUTCOME */
    /* OUTCOME */
    /* OUTCOME */
    /* OUTCOME */
    /* OUTCOME */

    function GetOutcomes(parentId) {

    }

    // CreateElement(elementType, className, name, placeholder, value, datasetValue, elementId, inputType)
    function CreateOutcome(parentId, inputValue, outcomesContainer, courseId) {

    }

    function CreateOutcomeButtons(parentId, container) {

    }

    function PostOutcome(id, parentId, inputField, inputValue) {

    }

    function RemoveOutcome(id) {
        RemoveEntity(id, "course-learning-outcome", "/course-learning-outcome/remove");
    }

    <?php $departments = $model->getDepartments(); ?>
    <?php foreach($departments as $department): ?>
        CreateDepartment(<?= $department->id ?>, '<?= $department->name ?>');
    <?php endforeach; ?>
</script>

<style>
    /* TODO Kristjan tõsta see pärast site.css faili. */
    .section-block, .speciality-study-modules {
        padding-top: 20px;
        padding-left: 20px;
    }
    textarea {
        display: block;
    }
</style>