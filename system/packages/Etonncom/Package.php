<?php

namespace Etonncom;

class Package extends \Lightyping\Framework\Package
{
    public function config()
    {
        return [
            'name' => 'Etonncom',
            'version' => '0.1',
            'description' => 'Etonn Website Package',
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
                'action' => 'Etonncom\Controller\HomeController::indexAction'
            ],
            [
                'method' => 'GET',
                'uri' => '/node/{id}',
                'action' => 'Etonncom\Controller\NodeController::getNodeByIdAction'
            ],
            [
                'method' => 'GET',
                'uri' => '/page/{alias}',
                'action' => 'Etonncom\Controller\NodeController::getNodeByAliasAction'
            ],
        ];
    }
}