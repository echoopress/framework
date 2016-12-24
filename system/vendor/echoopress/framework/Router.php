<?php
/**
 * Router.php
 */

namespace Echoopress\Framework;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router extends RouteCollection
{
    /**
     * All of the verbs supported by the router.
     *
     * @var array
     */
    // todo add methods checking
    public static $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

    /**
     * Add a route to the underlying route collection.
     *
     * @param  array|string  $methods
     * @param  string  $uri
     * @param  \Closure|array|string|null  $action
     * @return
     */
    public function addRoute($methods, $uri, $action)
    {
        $this->add($uri, $this->createRoute($methods, $uri, $action));
    }

    /**
     * Create a new route instance.
     *
     * @param  array|string  $methods
     * @param  string  $uri
     * @param  mixed  $action
     * @return \Symfony\Component\Routing\Route
     */
    protected function createRoute($methods, $uri, $action)
    {
        $route = new Route($uri);
        // If the route is a string and routing to a controller file
        if ($this->actionReferencesController($action))
        {
            $route->setDefault('_controller', $action);
        }
        else
        {
            $route->setDefault('_controller', function($argument = null) use ($action) {
                return new Response($action($argument));
            });
        }
        $route->setMethods($methods);

        return $route;
    }

    /**
     * Determine if the action is routing to a controller.
     *
     * @param  array  $action
     * @return bool
     */
    protected function actionReferencesController($action)
    {
        if ($action instanceof Closure) {
            return false;
        }
        return is_string($action);
    }

}