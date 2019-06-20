<?php 

use app\components\Alert;
use app\components\Identity;
use app\components\Helper;

?>

<?php if(!isset($content)) { $content = ""; } ?>
<?php if(!isset($title)) { $title = Helper::getTitle(); } ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title><?= $title; ?></title>
	<link rel="shortcut icon" type="image/png" href="https://www.tlu.ee/themes/tlu/images/favicons/favicon.ico"/>
	<link href="https://fonts.googleapis.com/css?family=Cousine&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="/css/site.css?v=1">
</head>
<body>
	<div class="top-menu base-align">
		<div class="left-menu">
			<a class="i-home" href="https://www.tlu.ee/">Avalehele</a>
			<a class="i-contact" href="https://www.tlu.ee/uldkontaktid">Kontakt</a>
			<a class="i-accessibility" href="https://www.tlu.ee/ligipaasetavus">Ligipääsetavus</a>
		</div>
		<div class="right-menu">
			<a href="https://www.facebook.com/tallinna.ylikool/">&nbsp;</a>
			<a href="https://twitter.com/tallinnaylikool">&nbsp;</a>
			<a href="https://www.instagram.com/tallinnuniversity/">&nbsp;</a>
			<a href="https://www.flickr.com/photos/tallinnuniversity/albums">&nbsp;</a>
			<a href="https://www.youtube.com/user/TallinnaYlikool">&nbsp;&nbsp;&nbsp;</a>
		</div>
	</div>
	<div class="lower-menu base-align" id="header-menu">
		<div class="left-menu">
		<a href="https://www.tlu.ee/dt"><img src="https://www.tlu.ee/sites/default/files/2018-05/DTI-est_2.svg" alt="Tallinna Ülikool"></a>
		</div>
		<div class="right-menu">
			<div class="link-bottom-aligner">
				<ul>
					<li><a href="https://www.tlu.ee/dt">Instituut</a></li>
					<li><a href="https://www.tlu.ee/dti/sisseastumine">Sisseastumine</a>
					<li><a class="active" href="https://www.tlu.ee/dt/oppetoo">Õpingud</a></li>
					<li><a href="https://www.tlu.ee/dt/teadlasele">Teadus</a></li>
					<li><a href="https://www.tlu.ee/dt/koolitused">Koolitused</a></li>
					<li><a href="https://www.tlu.ee/dt/meediavarav">Meediavärav</a></li>
					<li><a href="https://www.tlu.ee/dt/kontaktid">Kontaktid</a></li>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="banner-section">
		<div class="banner-image">
			<div class="breadcrumb-background">
				<ol>
					<li><a href="https://www.tlu.ee/">Avaleht</a></li>
					<li><a href="https://www.tlu.ee/dt">Digitehnoloogiate instituut</a></li>
				</ol>
			</div>
			<img src="https://www.tlu.ee/sites/default/files/styles/image_1300xn/public/2018-04/graphicstock-man-in-green-shirt-sitting-on-sofa-by-the-table-with-tablet-and-laptop-in-office-coworking_BU_wnPQOhe_2.jpg?itok=Y27grBuj" alt="poiss">
		</div>
	</div>
	
    <div class="container">
		<div class="menu-wrapper">
			<div class="menu-container">
				<div class="side-menu">
					<a href="https://www.tlu.ee/dt/oppetoo">Õppetöö</a>
					<a href="https://www.tlu.ee/oppeinfo">Õppeinfo</a>
					<a href="https://www.tlu.ee/dt/opingud/olulised-kuupaevad">Olulised kuupäevad</a>
					<a href="https://www.tlu.ee/dt/opingud/oppenoustajad-ja-spetsialistid">Õppenõustajad ja -spetsialistid</a>
					<a href="https://www.tlu.ee/dt/opingud/akadeemiline-raamatukogu">Akadeemiline raamatukogu</a>
					<a class="active" href="https://www.tlu.ee/dt/opingud/oppimine-valismaal">Õppimine välismaal</a>
				</div>
			</div>
		</div>
		
		<div class="content">
			<?= Alert::showMessages(); ?>
            <?php if(!Identity::isGuest()): ?>
				<div class="content-admin-button">
                    <a class="btn" href="/user/logout">Logi välja</a>
                    <a class="btn" href="/site/admin">Adminpaneel</a>
                </div>
            <?php endif; ?>
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
				<div class="footer-section footer-section-1">
					<h3>Tule ülikooli</h3>
					<a href="https://www.tlu.ee/opilasakadeemia">Õpilasakadeemia</a>
					<a href="https://www.tlu.ee/avatudope">Avatud tasemeõpe</a>
					<a href="https://www.tlu.ee/aastaylikoolis">Aasta ülikoolis</a>
					<a href="https://www.tlu.ee/konverentsikeskus/konverentsiteenused">Konverentsiteenused</a>
					<a href="https://www.tlu.ee/sisseastujale">Sisseastumine</a>
				</div>
				<div class="footer-section footer-section-2">
					<h3>Õpingud</h3>
					<a href="https://www.tlu.ee/akadeemiline-kalender">Akadeemiline kalender</a>
					<a href="https://www.tlu.ee/op/oppimine-valismaal">Õppimine välismaal</a>
					<a href="http://www.tlulib.ee/index.php/">Raamatukogu</a>
					<a href="https://www.tlu.ee/karj%C3%A4%C3%A4ri-n%C3%B5ustamiskeskus/karjaarinoustamine">Karjäärinõustamine</a>
					<a href="https://www.esindus.ee/">Üliõpilaselu</a>
					<a href="http://www.dormitorium.ee/">Üliõpilaselamud</a>
				</div>
				<div class="footer-section footer-section-3">
					<h3>Ülikoolist</h3>
					<a href="https://www.tlu.ee/taxonomy/term/93/pressikeskus">Pressikeskus</a>
					<a href="https://www.tlu.ee/ulikooli-linnak">Linnak</a>
					<a href="https://www.tlu.ee/vabad-ametikohad">Vabad ametikohad</a>
					<a href="http://www.tlu.ee/pood">E-pood</a>
					<a href="https://www.tlu.ee/uudiskiri">Liitu uudiskirjaga</a>
					<a href="https://www.tlu.ee/uldkontaktid">Üldkontaktid</a>
				</div>
			</div>
			<div class="lower-footer">
				<div class="logo-aligner">
					<div class="footer-logo-container"><a href="https://euraxess.ec.europa.eu/"><img src="https://www.tlu.ee/sites/default/files/styles/logo/public/2018-02/euraxess.png?itok=DaVs6YBF" alt="EURAXESS"></a></div>
					<div class="footer-logo-container"><a href="http://www.unica-network.eu/"><img src="https://www.tlu.ee/sites/default/files/styles/logo/public/2018-02/unica.png?itok=FjuLbc5B" alt="UNICA"></a></div>
					<div class="footer-logo-container"><a href="https://eua.eu/"><img src="https://www.tlu.ee/sites/default/files/styles/logo/public/2018-02/eua.png?itok=pm_WC44k" alt="EUA"></a></div>
					<div class="footer-logo-container"><a href="#"><img src="https://www.tlu.ee/sites/default/files/styles/logo/public/2018-02/observatory.png?itok=C6snr_HL" alt="Observatory"></a></div>
					<div class="footer-logo-container"><a href="#"><img src="https://www.tlu.ee/sites/default/files/styles/logo/public/2018-02/baltic.png?itok=FWLicpT3" alt="The Baltic University"></a></div>
					<div class="footer-logo-container"><a href="http://ekka.archimedes.ee/korgkoolile/institutsionaalne-akrediteerimine/hindamisotsused-ja-aruanded/"><img src="https://www.tlu.ee/sites/default/files/styles/logo/public/2018-02/accredited.png?itok=E5UX3cH2" alt="Accredited"></a></div>
				</div>
			</div>
		</div>
	</div>
	<script src="/main.js?v=1"></script>
</body>
</html>