<?php
/**
 * Application.php
 */

namespace Echoopress\Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernel;


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

        $this->container = Container::getInstance();
        $this->container->register('router', 'Echoopress\Framework\Router');
        $this->container->register('route_collection', 'Symfony\Component\Routing\RouteCollection');
        $this->container->register('event_dispatcher', 'Symfony\Component\EventDispatcher\EventDispatcher');
        $this->container->register('request_context', 'Symfony\Component\Routing\RequestContext');
        $this->container->register('request_stack', 'Symfony\Component\HttpFoundation\RequestStack');
        $this->container->register('controller_resolver', 'Symfony\Component\HttpKernel\Controller\ControllerResolver');
        $this->container->register('argument_resolver', 'Symfony\Component\HttpKernel\Controller\ArgumentResolver');
        $this->container->register('exception_listener', 'Symfony\Component\HttpKernel\EventListener\ExceptionListener')
            ->addArgument('Echoopress\Framework\ExceptionController::exceptionAction');
        $this->container->register('url_matcher', 'Symfony\Component\Routing\Matcher\UrlMatcher')
            ->addArgument($this->container->get('router'))
            ->addArgument($this->container->get('request_context'));
        $this->container->register('router_listener', 'Symfony\Component\HttpKernel\EventListener\RouterListener')
            ->addArgument($this->container->get('url_matcher'))
            ->addArgument($this->container->get('request_stack'));
        $this->container->register('templating', 'Echoopress\Framework\Templating');
    }

    public function get($uri, $action)
    {
        $this->route('GET', $uri, $action);
    }

    public function post($uri, $action)
    {
        $this->route('POST', $uri, $action);
    }

    /**
     * Add a route to the underlying route collection.
     *
     * @param  array|string  $methods
     * @param  string  $uri
     * @param  \Closure|array|string|null  $action
     * @return
     */
    public function route($methods, $uri, $action)
    {
        if (false === strpos($action, ':')) {
            // if $action is a package name, we register the package
            $this->container->register($action, $action.'\Package');
            // load package routes
            $routes = $this->container->get($action)->config();
            $this->container->get('router')->createPackageRoutes($routes['routes'], $routes['uri']);
        } else {
            $this->container->get('router')->route($methods, $uri, $action);
        }
    }

    public function run()
    {
        // create the Request object
        $request = Request::createFromGlobals();
        // set up route matcher
        $this->container->get('url_matcher');
        // create EventDispatcher
        $dispatcher = $this->container->get('event_dispatcher');
        // execute the routing layer, returns an array of information about the matched request,
        // including the _controller and any placeholders that are in the route's pattern
        $dispatcher->addSubscriber($this->container->get('router_listener'));
        // add exception controller event
        //$dispatcher->addSubscriber($this->container->get('ExceptionListener'));
        // create controller and argument resolvers
        $controllerResolver = $this->container->get('controller_resolver');
        $argumentResolver = $this->container->get('argument_resolver');
        // instantiate the kernel
        $kernel = new HttpKernel($dispatcher, $controllerResolver, $this->container->get('request_stack'), $argumentResolver);
        // execute the kernel, which turns the request into a response by dispatching events, and calling controller
        $response = $kernel->handle($request);
        // send the headers and echo the content
        $response->send();
        // triggers the kernel.terminate event
        $kernel->terminate($request, $response);
    }
}