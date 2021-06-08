<?php

namespace Demo;

class Package extends \Lightyping\Framework\Package
{
    public function config()
    {
        return [
            'name' => 'Demo',
            'version' => '0.1',
            'description' => 'Demo Package',
            'author' => 'Lightyping',
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
                'action' => 'Demo\Controller\DemoController::indexAction'
            ],
            [
                'method' => 'GET',
                'uri' => '/welcome/{name}',
                'action' => 'Demo\Controller\DemoController::welcomeAction'
            ],
            [
                'method' => 'POST',
                'uri' => '/post',
                'action' => 'Demo\Controller\DemoController::postAction'
            ],
            [
                'method' => 'GET',
                'uri' => '/test',
                'action' => 'Demo\Controller\DemoController::testAction'
            ],
        ];
    }
}