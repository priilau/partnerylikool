<?php
// NOTE(Caupo 11.06.2019): Failide järjekord on väga oluline. Failid, mida kutsutakse ennem teisi peavad olema ülevamal pool.

$files = [
	__DIR__ . '/../config/db.php',
    __DIR__ . '/../components/Helper.php',
    __DIR__ . '/../components/Identity.php',
    __DIR__ . '/../components/Request.php',
    __DIR__ . '/../components/GridView.php',
    __DIR__ . '/../components/DetailView.php',
	__DIR__ . '/../components/ActiveForm.php',
	__DIR__ . '/../components/Alert.php',
	__DIR__ . '/../components/Flash.php',
    __DIR__ . '/../components/BaseModel.php',
    __DIR__ . '/../components/ActiveRecord.php',
    __DIR__ . '/../components/Router.php',
	__DIR__ . '/../components/QueryBuilder.php',
    __DIR__ . '/../models/User.php',
    __DIR__ . '/../components/BaseController.php',
    __DIR__ . '/../models/LoginForm.php',
	__DIR__ . '/../models/University.php',
	__DIR__ . '/../models/Test.php',
    __DIR__ . '/../controllers/SiteController.php',
    __DIR__ . '/../controllers/UserController.php',
	__DIR__ . '/../controllers/UniversityController.php'
];

foreach($files as $file) {
	require($file);
}

?>