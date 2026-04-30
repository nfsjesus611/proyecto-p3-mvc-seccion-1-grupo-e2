<?php

$routes = [
    '/'                  => ['AuthController', 'login'],
    '/auth/login'         => ['AuthController', 'login'],
    '/auth/logout'         => ['AuthController', 'logout'],
    '/auth/register'         => ['AuthController', 'register'],
    '/admin'                   => ['AuthController', 'admin'],
];

?>
