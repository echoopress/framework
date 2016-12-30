<?php

namespace Homepage;

$routes = array(
    array(
        'method' => 'GET',
        'uri' => '/',
        'action' => 'Homepage\HomeController::indexAction'
    ),
);

return array(
    'name' => 'homepage',
    'version' => '0.1',
    'uri' => '', // empty
    'routes' => $routes
);