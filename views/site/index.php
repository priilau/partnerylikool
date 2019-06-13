<?php
use app\components\Helper;

Helper::setTitle("Pealeht");
?>

<h1><?= Helper::getTitle() ?></h1>

<div class="content-container">
	<div class="filter-container">
		<div class="filter-sub-container">
			<select><option>Bakalaureus</option></select>
			<select><option>K2020</option></select>
			<select><option>Digitaalne meedia</option></select>
			<div>
				<input id="praktika" type="checkbox"> <label for="praktika">Soovin välispraktikat</label>
			</div>
			<a href="#">Link juhendavale PDF-ile</a>
		</div>
		<div class="filter-sub-container">
			<h3>Teemad millest olen huvitatud</h3>
			<div class="filter-options">
				<div><input type="checkbox"> <label>Tarkvara arendus</label></div>
				<div><input type="checkbox"> <label>Mängude arendus</label></div>
				<div><input type="checkbox"> <label>Agiilsed arendusmeetodid</label></div>
				<div><input type="checkbox"> <label>Matemaatika</label></div>
				<div><input type="checkbox"> <label>Andmebaasid</label></div>
				<div><input type="checkbox"> <label>Lorem Ipsum</label></div>
				<div><input type="checkbox"> <label>Lorem Ipsum</label></div>
				<div><input type="checkbox"> <label>Lorem Ipsum</label></div>
				<div><input type="checkbox"> <label>Lorem Ipsum</label></div>
			</div>
		</div>
	</div>

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
