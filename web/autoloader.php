<?php
$files = [
	__DIR__ . '/../config/db.php',
	__DIR__ . '/../components/Router.php',
	__DIR__ . '/../components/QueryBuilder.php',
	__DIR__ . '/../models/BaseModel.php',
	__DIR__ . '/../models/University.php',
	__DIR__ . '/../models/Test.php',
	__DIR__ . '/../controllers/BaseController.php',
	__DIR__ . '/../controllers/SiteController.php',
	__DIR__ . '/../controllers/UniversityController.php'
];

foreach($files as $file) {
	require($file);
}

?>