<?php
use app\components\Helper;

Helper::setTitle("Pealeht");

?>

<h1><?= Helper::getTitle() ?></h1>

<div class="content-container">
	<div class="filter-container">
		<div class="filter-sub-container" id="left-sub">
			<select id="degree">
                <?php foreach($degrees as $key => $degree): ?>
                    <option value="<?= $key ?>"><?= $degree ?></option>
                <?php endforeach; ?>
            </select>
			<select id="semester">
                <?php foreach($semesters as $semesterKey => $semesterValue): ?>
                    <option value="<?= $semesterKey ?>"><?= $semesterValue ?></option>
                <?php endforeach; ?>
            </select>
			<select id="speciality">
                <?php foreach($specialities as $speciality): ?>
                    <option value="<?= $speciality ?>"><?= $speciality ?></option>
                <?php endforeach; ?>
            </select>
			<div>
				<input id="practice" type="checkbox"> <label for="practice">I want an internship</label>
			</div>
		</div>
		<div class="filter-sub-container" id="right-sub">
			<h3>Topics I am interested in</h3>
			<div class="filter-options">
				<input id="search-keywords" placeholder="Search...">
				<div class="keyword-results"></div>
			</div>
		</div>
	</div>
<div>
	<input type="button" class="btn btn-primary" id="search" value="Search">
</div>
	
	<div id="search-results" style="display: none;">
		<h2>Universities</h2>
		<div class="universities"></div>
	</div>
</div>

<script>
	let searchBtn = document.querySelector("#search");
	let degree = document.querySelector("#degree");
	let semester = document.querySelector("#semester");
	let speciality = document.querySelector("#speciality");
	let practice = document.querySelector("#practice");
	let topics = document.querySelectorAll(".topic");
	let universities = document.querySelector(".universities");
	let searchResults = document.querySelector("#search-results");
	let searchKeywords = document.querySelector("#search-keywords");
	let keywordResults = document.querySelector(".keyword-results");
	let timerHandler;
	let inputWords = [];
	let counter = 0;
	
	searchKeywords.addEventListener("input", function() {
		if(/\S/.test(searchKeywords.value) && (timerHandler !== null || timerHandler !== undefined)) {
			clearTimeout(timerHandler);
			timerHandler = setTimeout(GetKeywordResults, 3000);
		}
	});
	
	searchBtn.addEventListener("click", function() {
		let degreeVal = 0;
		let semesterVal = 0;
		let specialityVal = 0;
		let practiceVal = 0;
		
		if(degree !== null || degree !== undefined) {
			degreeVal = degree.value;
		}
		if(semester !== null || semester !== undefined) {
			semesterVal = parseInt(semester.value, 10);
		}
		if(speciality !== null || speciality !== undefined) {
			specialityVal = speciality.value;
		}
		if(practice !== null || practice !== undefined) {
			practiceVal = practice.checked ? 1 : 0;
		}
		
		let selectedTopics = [];
		
        for(let i = 0; i < topics.length; i++) {
			if(topics[i].checked){
				selectedTopics.push(topics[i].value);
            }
        }
		
		if(selectedTopics.length <= 0){
			alert("Valige mõni teema, millest olete huvitatud!");
			return;
		}
		
		let formData = new FormData();
		formData.append("degree", degreeVal);
		formData.append("semester", semesterVal);
		formData.append("speciality", specialityVal);
		formData.append("practice", practiceVal);
		formData.append("selectedTopics", JSON.stringify(selectedTopics));
		
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				ClearInner(universities);
				let data = JSON.parse(this.responseText);
				if(data === undefined || data === null || data.length <= 0){
					searchResults.style = "";
					CreateSearchMessage();
				} else {
					searchResults.style = "";
					RenderUniversities(data);
				}
			}
		};
		xhttp.open("POST", "/site/search", true);
		xhttp.send(formData);
	});

	function GetKeywordResults() {
		let inputText = searchKeywords.value;
		inputWords = inputText.split(" ");
		let formData = new FormData();
		formData.append("inputText", inputText);
		
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			ClearInner(keywordResults);
			if (this.readyState == 4 && this.status == 200) {
				let data = JSON.parse(this.responseText);
				RenderKeywords(data);
			}
		};
		xhttp.open("POST", "/site/getkeywords", true);
		xhttp.send(formData);
	}

	function RenderKeywords(data) {
		for(let i = 0; i < data.length; i++){
			CreateKeyword(data[i]['keyword']);
		}
	}

	function CreateKeyword(keyword) {
		let keywordContainer = document.createElement("div");
		keywordContainer.className = "keyword-result";
		for(let i = 0; i < inputWords.length; i++){
			if(keyword.includes(inputWords[i])){
				let matchPercent = (inputWords[i].length / keyword.length) * 100;

				if(matchPercent >= 50){
					let newKeyword = keyword.replace(inputWords[i], "<span style='font-weight: bold;'>" + inputWords[i] + "</span>")
					keywordContainer.innerHTML = newKeyword;
					counter++;
				}
			}
			console.log(counter);
			if(counter == 15){
				break;
			}
		}
		keywordResults.appendChild(keywordContainer);
	}

	function CreateSearchMessage() {
		let searchMsg = document.createElement("div");
		searchMsg.id = "search-msg";

		let msg = document.createElement("h4");
		msg.innerText = "Vastavaid ülikoole ei leitud!";
		searchMsg.appendChild(msg);
		universities.appendChild(searchMsg);
	}

	function CreateUniversity(name, icon, description, percent, link, map) {

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
		uniIcon.alt = "🎓";
		uniIconContainer.appendChild(uniIcon);
		
		let uniText = document.createElement("div");
		uniText.className = "description-text";
		uniText.innerHTML = description;
		
		let uniPerContainer = document.createElement("div");
		uniPerContainer.className = "percent-with-link";
		let uniPer = document.createElement("div");
		uniPer.innerHTML = Math.round(percent) + " %";
		uniPerContainer.appendChild(uniPer);
		
		let uniLinkContainer = document.createElement("div");
		let uniLink = document.createElement("a");
		uniLink.href = link;
		uniLink.target = "_blank";
		uniLink.innerHTML = "homepage";
		uniLinkContainer.appendChild(uniLink);
		uniPerContainer.appendChild(uniLinkContainer);
		
		let uniMapContainer = document.createElement("div");
		uniMapContainer.className = "university-map";
		let uniMap = document.createElement("a");
		uniMap.href = map;
		uniMap.target = "_blank";
		uniMap.innerText = "🗺";
		uniMap.className = "map-link";

		uniMapContainer.appendChild(uniMap);
		
		uniBlock.appendChild(uniHeader);
		uniContainer.appendChild(uniIconContainer);
		uniContainer.appendChild(uniText);
		uniContainer.appendChild(uniPerContainer);
		uniContainer.appendChild(uniMapContainer);
		uniBlock.appendChild(uniContainer);
		universities.appendChild(uniBlock);
	}

	function RenderUniversities(resultArr){
		for(let i = 0; i < resultArr.length; i++){
			CreateUniversity(resultArr[i]["name"], resultArr[i]["icon"], resultArr[i]["description"], resultArr[i]["match"], resultArr[i]["link"], resultArr[i]["map"]);
		}
	}

	function ClearInner(node) {
		while (node.hasChildNodes()) {
			Clear(node.firstChild);
		}
	}

	function Clear(node) {
		while (node.hasChildNodes()) {
			Clear(node.firstChild);
		}
		node.parentNode.removeChild(node);
	}
</script>