<?php if(!isset($content)) { $content = ""; } ?>
<?php if(!isset($title)) { $title = "Partnerülikool"; } ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
	<link href="https://fonts.googleapis.com/css?family=Cousine&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="/site.css?v=1">
</head>
<body>
	<div class="top-menu base-align">
		<div class="left-menu">
			<a class="i-home" href="#">Avalehele</a>
			<a class="i-contact" href="#">Kontakt</a>
			<a class="i-accessibility" href="#">Ligipääsetavus</a>
		</div>
		<div class="right-menu">
			<a href="https://www.facebook.com/tallinna.ylikool/">&nbsp;</a>
			<a href="https://twitter.com/tallinnaylikool">&nbsp;</a>
			<a href="https://www.instagram.com/tallinnuniversity/">&nbsp;</a>
			<a href="https://www.flickr.com/photos/tallinnuniversity/albums">&nbsp;</a>
			<a href="https://www.youtube.com/user/TallinnaYlikool">&nbsp;&nbsp;&nbsp;</a>
		</div>
	</div>
	<div class="lower-menu base-align">
		<div class="right-menu">
			<img src="https://www.tlu.ee/sites/default/files/2018-05/DTI-est_2.svg" alt="Tallinna Ülikool">
		</div>
		<div class="left-menu">
			<div class="link-bottom-aligner">
				<a href="#">Instituut</a>
				<a href="#">Sisseastumine</a>
				<a class="active" href="#">Õpingud</a>
				<a href="#">Teadus</a>
				<a href="#">Koolitused</a>
				<a href="#">Meediavärav</a>
				<a href="#">Kontaktid</a>
			</div>
		</div>
	</div>
	
	<div class="banner-section">
		<div class="banner-image">
			<div class="breadcrumb-background">
				<ol>
					<li>Avaleht</li>
					<li>Digitehnoloogiate instituut</li>
				</ol>
			</div>
			<img src="https://www.tlu.ee/sites/default/files/styles/image_1300xn/public/2018-04/graphicstock-man-in-green-shirt-sitting-on-sofa-by-the-table-with-tablet-and-laptop-in-office-coworking_BU_wnPQOhe_2.jpg?itok=Y27grBuj" alt="poiss">
		</div>
	</div>
	
    <div class="container">
		<div class="menu-wrapper">
			<div class="menu-container">
				<div class="side-menu">
					<a href="#">Õppetöö</a>
					<a href="#">Õppeinfo</a>
					<a href="#">Olulised kuupäevad</a>
					<a href="#">Õppenõustajad ja -spetsialistid</a>
					<a href="#">Akadeemiline raamatukogu</a>
					<a class="active" href="#">Õppimine välismaal</a>
				</div>
			</div>
		</div>
		
		<div class="content">
			<?= $content; ?>
		</div>
    </div>
	
	<div class="footer">
		<div class="red-section">
			<img src="https://www.tlu.ee/themes/tlu/images/logo-small.svg" alt="TLÜ">
			<div class="information">
				<p>Tallinna Ülikool</p>
				<p>Narva mnt 25, 10120 Tallinn</p>
				<p>+372 640 9101</p>
				<p><a href="mailto:tlu@tlu.ee">tlu@tlu.ee</a></p>
			</div>
		</div>
		<div class="white-section">
			<div class="upper-footer">
				<div class="footer-section">
					<h3>Tule ülikooli</h3>
					<a href="#">Õpilasakadeemia</a>
					<a href="#">Avatud tasemeõpe</a>
					<a href="#">Aasta ülikoolis</a>
					<a href="#">Konverentsiteenused</a>
					<a href="#">Sisseastumine</a>
				</div>
				<div class="footer-section">
					<h3>Õpingud</h3>
					<a href="#">Akadeemiline kalender</a>
					<a href="#">Õppimine välismaal</a>
					<a href="#">Raamatukogu</a>
					<a href="#">Karjäärinõustamine</a>
					<a href="#">Üliõpilaselu</a>
					<a href="#">Üliõpilaselamud</a>
				</div>
				<div class="footer-section">
					<h3>Ülikoolist</h3>
					<a href="#">Pressikeskus</a>
					<a href="#">Linnak</a>
					<a href="#">Vabad ametikohad</a>
					<a href="#">E-pood</a>
					<a href="#">Liitu uudiskirjaga</a>
					<a href="#">Üldkontaktid</a>
				</div>
			</div>
			<div class="lower-footer">
				<div class="logo-aligner">
					<div class="footer-logo-container"><a href="#"><img src="https://www.tlu.ee/sites/default/files/styles/logo/public/2018-02/euraxess.png?itok=DaVs6YBF" alt="EURAXESS"></a></div>
					<div class="footer-logo-container"><a href="#"><img src="https://www.tlu.ee/sites/default/files/styles/logo/public/2018-02/unica.png?itok=FjuLbc5B" alt="UNICA"></a></div>
					<div class="footer-logo-container"><a href="https://eua.eu/"><img src="https://www.tlu.ee/sites/default/files/styles/logo/public/2018-02/eua.png?itok=pm_WC44k" alt="EUA"></a></div>
					<div class="footer-logo-container"><a href="#"><img src="https://www.tlu.ee/sites/default/files/styles/logo/public/2018-02/observatory.png?itok=C6snr_HL" alt="Observatory"></a></div>
					<div class="footer-logo-container"><a href="#"><img src="https://www.tlu.ee/sites/default/files/styles/logo/public/2018-02/baltic.png?itok=FWLicpT3" alt="The Baltic University"></a></div>
					<div class="footer-logo-container"><a href="http://ekka.archimedes.ee/korgkoolile/institutsionaalne-akrediteerimine/hindamisotsused-ja-aruanded/"><img src="https://www.tlu.ee/sites/default/files/styles/logo/public/2018-02/accredited.png?itok=E5UX3cH2" alt="Accredited"></a></div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>