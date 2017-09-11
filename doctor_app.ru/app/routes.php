<?php

$app->mount('/', include 'routes/main-routes.php');
$app->mount('/user', include 'routes/user-routes.php');