<?php
use app\components\Helper;

Helper::setTitle("Pealeht");

?>

<h1><?= Helper::getTitle() ?></h1>

<div class="content-container">
	<div class="filter-container">
		<div class="filter-sub-container">
			<select id="degree">
                <?php foreach($degrees as $key => $degree): ?>
                    <option value="<?= $key ?>"><?= $degree ?></option>
                <?php endforeach; ?>
            </select>
			<select id="semester">
                <?php foreach($semesters as $semester): ?>
                    <option value="<?= $semester ?>"><?= $semester ?></option>
                <?php endforeach; ?>
            </select>
			<select id="speciality">
                <?php foreach($specialities as $speciality): ?>
                    <option value="<?= $speciality ?>"><?= $speciality ?></option>
                <?php endforeach; ?>
            </select>
			<div>
				<input id="practice" type="checkbox"> <label for="practice">Soovin välispraktikat</label>
			</div>
		</div>
		<div class="filter-sub-container">
			<h3>Teemad millest olen huvitatud</h3>
			<div class="filter-options">
				<?php foreach($topics as $topic): ?>
					<div>
						<input type="checkbox" class="topic" id="topic-id-<?= $topic->id ?>" value="<?= $topic->id ?>">
						<label for="topic-id-<?= $topic->id ?>"><?= $topic->name ?></label>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<input type="button" class="btn btn-primary" id="search" value="Otsi">
	
	<div id="search-results">
		<h2>Ülikoolid</h2>
		<div class="universities">
			<div class="university">
				<h3>Ülikool 1</h3>
				<div class="university-description">
					<div class="university-icon"><img src="https://pbs.twimg.com/profile_images/679594326691741696/of9OpXVv.png"></div>
					<div class="description-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
					<div class="percent-with-link">
						<div>80%</div>
						<div><a href="#">wwwcom</a></div>
					</div>
					<div class="university-map"><img src="https://custom-map-source.appspot.com/galileo-google-maps.png"></div>
				</div>
			</div>
			<div class="university">
				<h3>Ülikool 1</h3>
				<div class="university-description">
					<div class="university-icon"><img src="https://pbs.twimg.com/profile_images/679594326691741696/of9OpXVv.png"></div>
					<div class="description-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
					<div class="percent-with-link">
						<div>80%</div>
						<div><a href="#">wwwcom</a></div>
					</div>
					<div class="university-map"><img src="https://custom-map-source.appspot.com/galileo-google-maps.png"></div>
				</div>
			</div>
			<div class="university">
				<h3>Ülikool 1</h3>
				<div class="university-description">
					<div class="university-icon"><img src="https://pbs.twimg.com/profile_images/679594326691741696/of9OpXVv.png"></div>
					<div class="description-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
					<div class="percent-with-link">
						<div>80%</div>
						<div><a href="#">wwwcom</a></div>
					</div>
					<div class="university-map"><img src="https://custom-map-source.appspot.com/galileo-google-maps.png"></div>
				</div>
			</div>
		</div>
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

	searchBtn.addEventListener("click", function(){
		let degreeVal = 0;
		let semesterVal = 0;
		let specialityVal = 0;
		let practiceVal = 0;

		if(degree !== null || degree !== undefined){
			degreeVal = degree.value;
		}
		if(semester !== null || semester !== undefined){
			semesterVal = semester.value;
		}
		if(speciality !== null || speciality !== undefined){
			specialityVal = speciality.value;
		}
		if(practice !== null || practice !== undefined){
			practiceVal = practice.checked ? 1 : 0;
		}

		let selectedTopics = [];
		
        for(let i = 0; i < topics.length; i++){
            if(topics[i].checked){
                selectedTopics.push(topics[i].value);
            }
        }

		if(selectedTopics.length > 0){
			let formData = new FormData();
			formData.append("degree", degreeVal);
			formData.append("semester", semesterVal);
			formData.append("speciality", specialityVal);
			formData.append("practice", practiceVal);
			formData.append("selectedTopics", JSON.stringify(selectedTopics));

			let xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.responseText);
					RenderUniversities(JSON.parse(this.responseText));
				}
			};
			xhttp.open("POST", "/site/search", true);
			xhttp.send(formData);
		} else {
			alert("Valige mõni teema, millest olete huvitatud!");
		}
	});

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

function RenderUniversities(resultArr){
	console.log(resultArr);
    for(let i = 0; i < resultArr.length; i++){
		console.log(resultArr[i]);
        //CreateUniversity(resultArr["name"], resultArr["icon"], resultArr["description"], resultArr["percent"], resultArr["link"], resultArr["map"])
    }
} 
</script>