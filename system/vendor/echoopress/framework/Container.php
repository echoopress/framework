<?php
/**
 * Container.php
 */

namespace Echoopress\Framework;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class Container extends ContainerBuilder
{
    private static $instance = NULL;

    /**
     * Get Container instance, singleton pattern.
     *
     * @return Container instance
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c();
        }
        return self::$instance;
    }

    /**
     * Registers a service definition.
     *
     * @param $package string
     * @return \Symfony\Component\DependencyInjection\Definition A Definition instance
     */
    public function registerPackage($package)
    {
        return $this->register('package_'.$package, $package.'\Package');
    }

    /**
     * Gets a service.
     *
     * @param $package string
     * @return object The associated service
     */
    public function getPackage($package)
    {
        return $this->get('package_'.$package);
    }
}
