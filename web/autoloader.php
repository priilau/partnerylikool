<?php
$files = [
	__DIR__ . '/../config/db.php',
    __DIR__ . '/../components/Request.php',
    __DIR__ . '/../components/GridView.php',
    __DIR__ . '/../components/DetailView.php',
	__DIR__ . '/../components/ActiveForm.php',
	__DIR__ . '/../components/BaseModel.php',
    __DIR__ . '/../components/ActiveRecord.php',
    __DIR__ . '/../components/Router.php',
	__DIR__ . '/../components/QueryBuilder.php',
    __DIR__ . '/../components/BaseController.php',
	__DIR__ . '/../models/University.php',
	__DIR__ . '/../models/Test.php',
	__DIR__ . '/../controllers/SiteController.php',
	__DIR__ . '/../controllers/UniversityController.php'
];

foreach($files as $file) {
	require($file);
}

?>