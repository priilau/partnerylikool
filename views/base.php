<?php if(!isset($content)) { $content = ""; } ?>
<?php if(!isset($title)) { $title = "Partnerülikool"; } ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" type="text/css" href="/site.css?v=1">
</head>
<body>
    <div class="container">
        <?= $content; ?>
    </div>
</body>
</html>