<?php
/**
 * Container.php
 */

namespace Echoopress\Framework;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class Container extends ContainerBuilder
{
    private static $instance = NULL;

    public static function getInstance()
    {
        if (is_null(self::$instance))
        {
            $c = __CLASS__;
            self::$instance = new $c();
        }
        return self::$instance;
    }
}
