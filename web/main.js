console.log("main.js töötab");

// site/index.php
window.onscroll = function() { scrollHeader(); }

let header = document.getElementById("header-menu");
let sticky = header.offsetTop;
let filtersArr = {};
let degree = document.querySelector("#degree");
let semester = document.querySelector("#semester");
let speciality = document.querySelector("#speciality");
let practice = document.querySelector("#practice");
let topicsArr = document.querySelectorAll("#topics");
let universities = document.querySelector(".universities");

if(degree !== null && degree !== undefined) {
    let arrayVal = degree.options[degree.selectedIndex].value;
    degree.addEventListener("change", function() {
        filtersArr.degree = arrayVal;
        FetchResults();
    });
}

if(semester !== null && semester !== undefined) {
    let arrayVal = semester.options[semester.selectedIndex].value;
    semester.addEventListener("change", function() {
        filtersArr.semester = arrayVal;
        FetchResults();
    });
}

if(speciality !== null && speciality !== undefined) {
    let arrayVal = speciality.options[speciality.selectedIndex].value;
    speciality.addEventListener("change", function() {
        filtersArr.speciality = arrayVal;
        FetchResults();
    });
}

if(practice !== null && practice !== undefined) {
    let arrayVal = practice.options[practice.selectedIndex].value;
    practice.addEventListener("change", function() {
        filtersArr.practice = arrayVal;
        FetchResults();
    });
}

if(topicsArr !== null && topicsArr !== undefined) {
    for (let i = 0; i < topicsArr.length; i++) {
        if (topicsArr[i].selected) {
            selectedArr.push(topicsArr[i].value);
        }
        topicsArr[i].addEventListener("change", function() {
            filtersArr.topicsArr = selectedArr;
            FetchResults();
        });
    }
}

function FetchResults(){
    let formData = new FormData();
	formData.append("filtersArr", filtersArr);

	let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("input").innerHTML = this.responseText;
            console.log("FetchResults");
            console.log("filtersArr: ", filtersArr);
        }
    };
    xhttp.open("POST", "/university/getResults", true);
	xhttp.send(formData);
}

function CreateUniversity(name, icon, description, percent, link, map){
    let uniBlock = document.createElement("div");
    uniBlock.className = "university";
    
    let uniHeader = document.createElement("h3");
    uniHeader.innerHTML = name;
    
    let uniContainer = document.createElement("div");
    uniContainer.className = "university-description";
    
    let uniIconContainer = document.createElement("div");
    uniIconContainer.className = "university-icon";
    let uniIcon = document.createElement("img");
    uniIcon.src = icon;
    uniIconContainer.appendChild(uniIcon);
    
    let uniText = document.createElement("div");
    uniText.className = "description-text";
    uniText.innerHTML = description;
    
    let uniPerContainer = document.createElement("div");
    uniPerContainer.className = "percent-with-link";
    let uniPer = document.createElement("div");
    uniPer.innerHTML = percent;
    uniPerContainer.appendChild(uniPer);
    
    let uniLinkContainer = document.createElement("div");
    let uniLink = document.createElement("a");
    uniLink.href = link;
    uniLink.innerHTML = "wwwcom";
    uniLinkContainer.appendChild(uniLink);
    uniPerContainer.appendChild(uniLinkContainer);
    
    let uniMapContainer = document.createElement("div");
    uniMapContainer.className = "university-map";
    let uniMap = document.createElement("img");
    uniMap.src = map;
    uniMapContainer.appendChild(uniMap);

    uniBlock.appendChild(uniHeader);
    uniContainer.appendChild(uniIconContainer);
    uniContainer.appendChild(uniText);
    uniContainer.appendChild(uniPerContainer);
    uniContainer.appendChild(uniMapContainer);
    uniBlock.appendChild(uniContainer);
    universities.appendChild(uniBlock);
}

function scrollHeader() {
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
}