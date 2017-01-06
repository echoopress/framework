<?php
/**
 * Package.php
 */

namespace Lightyping\Framework;

abstract class Package implements PackageInterface
{
    public function __construct()
    {
        // Add ControllerInitializedEvent Listener
        $dispatcher = Container::getInstance()->get('event_dispatcher');
        $dispatcher->addListener(ControllerInitializedEvent::NAME, function(ControllerInitializedEvent $event){
            $event->setConfig($this->config());
        });
    }
}