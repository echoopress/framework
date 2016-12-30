<?php
/**
 * Application.php
 */

namespace Echoopress\Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class Application
{

    const VERSION = '0.0.1';

    public $container;

    public function __construct()
    {
        // todo config setting
        date_default_timezone_set('UTC');
        if (DEBUG) {
            \Symfony\Component\Debug\Debug::enable();
        }

        $this->container = new ContainerBuilder();
        $this->container->register('Router', 'Echoopress\Framework\Router');
        $this->container->register('RouteCollection', 'Symfony\Component\Routing\RouteCollection');
        $this->container->register('EventDispatcher', 'Symfony\Component\EventDispatcher\EventDispatcher');
        $this->container->register('RequestContext', 'Symfony\Component\Routing\RequestContext');
        $this->container->register('RequestStack', 'Symfony\Component\HttpFoundation\RequestStack');
        $this->container->register('ControllerResolver', 'Symfony\Component\HttpKernel\Controller\ControllerResolver');
        $this->container->register('ArgumentResolver', 'Symfony\Component\HttpKernel\Controller\ArgumentResolver');
        $this->container->register('ExceptionListener', 'Symfony\Component\HttpKernel\EventListener\ExceptionListener')
            ->addArgument('Echoopress\Framework\ExceptionController::exceptionAction');
        $this->container->register('UrlMatcher', 'Symfony\Component\Routing\Matcher\UrlMatcher')
            ->addArgument($this->container->get('Router'))
            ->addArgument($this->container->get('RequestContext'));
        $this->container->register('RouterListener', 'Symfony\Component\HttpKernel\EventListener\RouterListener')
            ->addArgument($this->container->get('UrlMatcher'))
            ->addArgument($this->container->get('RequestStack'));
    }

    public function get($uri, $action = null)
    {
        $this->container->get('Router')->route('GET', $uri, $action);
    }

    public function post($uri, $action = null)
    {
        $this->container->get('Router')->route('POST', $uri, $action);
    }

    public function run()
    {
        // create the Request object
        $request = Request::createFromGlobals();
        // set up route matcher
        $this->container->get('UrlMatcher');
        // create EventDispatcher
        $dispatcher = $this->container->get('EventDispatcher');
        // execute the routing layer, returns an array of information about the matched request,
        // including the _controller and any placeholders that are in the route's pattern
        $dispatcher->addSubscriber($this->container->get('RouterListener'));
        // add exception controller event
        //$dispatcher->addSubscriber($this->container->get('ExceptionListener'));
        // create controller and argument resolvers
        $controllerResolver = $this->container->get('ControllerResolver');
        $argumentResolver = $this->container->get('ArgumentResolver');
        // instantiate the kernel
        $kernel = new HttpKernel($dispatcher, $controllerResolver, $this->container->get('RequestStack'), $argumentResolver);
        // execute the kernel, which turns the request into a response by dispatching events, and calling controller
        $response = $kernel->handle($request);
        // send the headers and echo the content
        $response->send();
        // triggers the kernel.terminate event
        $kernel->terminate($request, $response);
    }
}