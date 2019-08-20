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
		<div class="selected-topics"></div>
	</div>
	<div>
		<input type="button" class="btn" id="search" value="Search">
		<div id="load-msg" style="display: none;"></div>
	</div>
	
	<div id="search-results" style="display: none;">
		<h2>Universities</h2>
		<div class="universities"></div>
	</div>
</div>

<script>
	let searchBtn = document.querySelector("#search");
	let loadMsg = document.querySelector("#load-msg");
	let degree = document.querySelector("#degree");
	let semester = document.querySelector("#semester");
	let speciality = document.querySelector("#speciality");
	let practice = document.querySelector("#practice");
	let topics = document.querySelector(".selected-topics");
	let universities = document.querySelector(".universities");
	let searchResults = document.querySelector("#search-results");
	let searchKeywords = document.querySelector("#search-keywords");
	let keywordResults = document.querySelector(".keyword-results");
	let timerHandler;
	let inputWords = [];
	let selectedTopics = [];
	let selection = 0;
	let isOnResults = false;
	let getExamples = true;
	let startCheck = true;

	keywordResults.addEventListener("mouseover", function() {
		isOnResults = true;
	});

	keywordResults.addEventListener("mouseout", function() {
		isOnResults = false;
	});

	searchKeywords.addEventListener("blur", function() {
		if(!isOnResults){
			keywordResults.style.display = "none";
		}
	});

	window.addEventListener("keyup", function(event) {
		let maxValue = 10;
		let results = document.querySelectorAll(".keyword-result");
		
		if(searchKeywords.value != "") {
			maxValue = inputWords.length;
		}
		event.preventDefault();
		
		if(results.length > 0 && keywordResults.style.display != "none"){
			switch (event.key) { 
				case "ArrowUp":
					if(selection == 0){
						selection = maxValue - 1;
					} else {
						selection--;
					}
					
					for(let i = 0; i < maxValue; i++){
						if(results[i].classList.contains("active")){
							results[i].classList.remove("active");
						}
					}
					results[selection].classList.add("active");
					break;
					
				case "ArrowDown":
					if(selection == maxValue - 1){
						selection = 0;
					} else if(!startCheck){
						selection++;
					} else {
						startCheck = false;
					}
					
					for(let i = 0; i < maxValue; i++){
						if(results[i].classList.contains("active")){
							results[i].classList.remove("active");
						}
					}
					results[selection].classList.add("active");
					break;
				}
			}
	});

	searchKeywords.addEventListener("focus", function() {
		keywordResults.style.display = "block";
		if(getExamples){
			GetKeywordResults();
			getExamples = false;
		}

		searchKeywords.addEventListener("input", function() {
			if(/\S/.test(searchKeywords.value) && (timerHandler !== null || timerHandler !== undefined)) {
				clearTimeout(timerHandler);
				timerHandler = setTimeout(GetKeywordResults, 2000);
			}
		});
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
		
		if(selectedTopics.length <= 0){
			alert("Valige mõni teema, millest olete huvitatud!");
			return;
		}

		loadMsg.style.display = "inline";
		loadMsg.innerText = "Loading...";

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
					loadMsg.style.display = "none";
				} else {
					searchResults.style = "";
					RenderUniversities(data);
					loadMsg.style.display = "none";
				}
			}
		};
		xhttp.open("POST", "/site/search", true);
		xhttp.send(formData);
	});

	function GetKeywordResults() {
		let inputText = searchKeywords.value.trim();
		inputWords = inputText.split(" ");
		let formData = new FormData();
		formData.append("inputText", inputText);
		formData.append("getExamples", getExamples);
		
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
		selection = 0;
		startCheck = true;
		for(let i = 0; i < data.length; i++){
			CreateKeyword(data[i]['id'], data[i]['keyword']);
		}
	}

	function CreateKeyword(id, keyword) {
		let keywordContainer = document.createElement("div");
		keywordContainer.className = "keyword-result";
		let resultContainer = document.createElement("div");
		resultContainer.className = "result-content";

		for(let i = 0; i < inputWords.length; i++){
			if(keyword.includes(inputWords[i])){
				let newKeyword = keyword.replace(inputWords[i], "<span style='font-weight: bold;'>" + inputWords[i] + "</span>");
				resultContainer.innerHTML = newKeyword;
				keywordResults.style.display = "block";
				
				keywordContainer.addEventListener("click", function() {
					AddKeywordToSelected(id, keyword);
				});

				keywordContainer.addEventListener("mouseover", function() {
					keywordContainer.classList.add("active");
				});

				keywordContainer.addEventListener("mouseout", function() {
					keywordContainer.classList.remove("active");
				});

				window.addEventListener("keyup", function(event) {
					event.preventDefault();
					
					if(event.key == "Enter" && keywordContainer.classList.contains("active")){
						AddKeywordToSelected(id, keyword);
					}
				});

				keywordContainer.appendChild(resultContainer);
				keywordResults.appendChild(keywordContainer);
			}
		}
	}

	function AddKeywordToSelected(id, keyword){
		if(!selectedTopics.includes(id)){
			let selectedTopic = document.createElement("div");
			selectedTopic.className = "selected-topic";
			let topicContent = document.createElement("div");

			topicContent.className = "topic-content";
			topicContent.innerHTML = "<label for='keyword-" + id + "'><span id='keyword-" + id + "'>" + keyword + "</span><input type='button' id='del-keyword-" + id + "' data-keyword-id='" + id + "'  class ='btn btn-primary' value='X'></label>";

			selectedTopic.appendChild(topicContent);
			topics.appendChild(selectedTopic);
			selectedTopics.push(id);

			document.querySelector("#del-keyword-" + id).addEventListener("click", function() {
				topics.removeChild(selectedTopic);
				let index = selectedTopics.indexOf(id);
				selectedTopics.splice(index, 1);
			});
		}
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
		uniText.innerText = description;
		
		let uniPerContainer = document.createElement("div");
		uniPerContainer.className = "percent-with-link";
		let uniPer = document.createElement("div");
		uniPer.innerText = Math.round(percent) + " %";
		uniPerContainer.appendChild(uniPer);
		
		let uniLinkContainer = document.createElement("div");
		let uniLink = document.createElement("a");
		uniLink.href = link;
		uniLink.target = "_blank";
		uniLink.innerText = "homepage";
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