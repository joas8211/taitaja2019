<?php

namespace App;

use Symfony\Component\Routing\RouterInterface;

/**
 * Service for rendering Vue.js page component.
 */
class VueRenderer
{
    public $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Get routes in correct format for Vue Router.
     */
    public function getRoutes(): array
    {
        $routes = [];

        $routeCollection = $this->router->getRouteCollection();
        foreach ($routeCollection as $name => $route)
        {
            // Do not include non-page routes.
            if (!$route->getDefault('_page')) continue;

            $path = $route->getPath();

            // Replace placeholders.
            // {name} -> :name
            $path = preg_replace('/{(\w+)}/', ':$1', $path); 

            $routes[] = [
                'name' => $name,
                'path' => $path,
            ];
        }

        return $routes;
    }

    /**
     * Render page preferring JS render.
     */
    public function render()
    {
        if (class_exists('V8js'))
        {
            $this->renderWithJS();
        }
        {
            $this->renderWithPHP();
        }
    }

    /**
     * Pre-render page using V8js and Vue's server-side-rending (SSR) library.
     */
    public function renderWithJS()
    {

    }

    /**
     * Render page without pre-rendering.
     */
    public function renderWithPHP()
    {
        require '../templates/default.php';
    }
}