<?php

namespace Homepage;

class Package implements \Echoopress\Framework\Package
{
    public function config()
    {
        return array(
            'name' => 'Homepage',
            'version' => '0.1',
            'description' => '',
            'author' => '',
            'theme' => '/theme/default',
            'uri' => '', // Necessary. empty for homepage
            'routes' => $this->routes(),
        );
    }

    public function routes()
    {
        return array(
            array(
                'method' => 'GET',
                'uri' => '/',
                'action' => 'Homepage\Controller\HomeController::indexAction'
            ),
            array(
                'method' => 'GET',
                'uri' => '/welcome/{name}',
                'action' => 'Homepage\Controller\HomeController::welcomeAction'
            ),
            array(
                'method' => ['GET', 'POST'],
                'uri' => '/post',
                'action' => 'Homepage\Controller\HomeController::postAction'
            ),
        );
    }
}