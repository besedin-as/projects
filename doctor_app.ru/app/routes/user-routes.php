<?php
$user = $app['controllers_factory'];
$user->get('/', 'user_controller:index')->bind('user.index');
$user->get('/admin', 'user_controller:admin')->bind('user.admin');

$user->get('/login', 'user_controller:login')->bind('user.login');
$user->post('/login', 'user_controller:login');

$user->get('/register', 'user_controller:register')->bind('user.register');
$user->post('/register', 'user_controller:register');

$user->get('/logout', 'user_controller:register')->bind('user.logout');
$user->post('/logout', 'user_controller:register');

$user->get('/reminder', 'user_controller:reminder')->bind('user.reminder');
$user->post('/reminder', 'user_controller:reminder');

$user->get('/logout', 'user_controller:logout')->bind('user.logout');

$user->get('/confirmation', 'user_controller:confirmation')->bind('user.confirmation');


return $user;