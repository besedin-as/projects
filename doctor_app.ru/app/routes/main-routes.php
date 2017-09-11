<?php

$main = $app['controllers_factory'];
$main->get('/', 'main_controller:index')->bind('index.index');
$main->post('/', 'main_controller:index');


return $main;