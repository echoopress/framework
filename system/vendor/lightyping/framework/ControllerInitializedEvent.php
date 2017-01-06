<?php
/**
 * ControllerInitializedEvent.php
 */

namespace Lightyping\Framework;

use Symfony\Component\EventDispatcher\Event;

class ControllerInitializedEvent extends Event
{
    const NAME = 'controller.initialize';

    protected $config;

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }
}