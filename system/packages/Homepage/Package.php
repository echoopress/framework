<?php

namespace Homepage;

class Package implements \Echoopress\Framework\Package
{
    public function config()
    {
        return [
            'name' => 'Homepage',
            'version' => '0.1',
            'description' => '',
            'author' => '',
            'theme' => '/theme/default',
            'uri' => '', // Necessary. empty for homepage
            'path' => __DIR__,
            'routes' => $this->routes(),
        ];
    }

    public function routes()
    {
        return [
            [
                'method' => 'GET',
                'uri' => '/',
                'action' => 'Homepage\Controller\HomeController::indexAction'
            ],
            [
                'method' => 'GET',
                'uri' => '/welcome/{name}',
                'action' => 'Homepage\Controller\HomeController::welcomeAction'
            ],
            [
                'method' => ['GET', 'POST'],
                'uri' => '/post',
                'action' => 'Homepage\Controller\HomeController::postAction'
            ],
            [
                'method' => 'GET',
                'uri' => '/test',
                'action' => 'Homepage\Controller\HomeController::testAction'
            ],
        ];
    }
}