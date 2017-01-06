<?php
/**
 * Router.php
 */

namespace Lightyping\Framework;

use Closure;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Routing extends RouteCollection
{
    /**
     * Create route instances for package
     *
     * @param $routes array
     * @param $packageUri string
     */
    public function createPackageRoutes($routes, $packageUri)
    {
        foreach ($routes as $route) {
            $uri = $packageUri.$route['uri'];
            $this->add($uri, $this->createRoute($route['method'], $uri, $route['action']));
        }
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
        if ($this->actionReferencesController($action)) {
            $route->setDefault('_controller', $action);
        } else {
            // todo convert String to Response type
            $route->setDefault('_controller', $action);
        }
        $route->setMethods($methods);

        return $route;
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
        $this->add($uri, $this->createRoute($methods, $uri, $action));
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

    /**
     * Generates a URL from the given parameters.
     *
     * @param string $route         The name of the route
     * @param mixed  $parameters    An array of parameters
     * @param int    $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     *
     * @return string The generated URL
     *
     * @see UrlGeneratorInterface
     */
    public function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        //$context = $this->container->get('request_context');
        //$routes = $this->container->get('routing');

        $generator = new \Symfony\Component\Routing\Generator\UrlGenerator($this, new RequestContext());

        $url = $generator->generate($route, $parameters, $referenceType);
        return $url;
    }
}