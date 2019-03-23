<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\VueRenderer;

class PageController extends AbstractController
{
    public function show(Request $request, VueRenderer $renderer)
    {
        $routeId = $request->attributes->get('_route');

        // Define scripts
        $scripts = [];
        $scripts[] = [
            'content' => 'window._page_ = ' . json_encode($routeId),
        ];
        $scripts[] = [
            'type' => 'module',
            'src' => $request->getBaseUrl() . '/assets/app.js',
        ];

        // Render using default document template
        ob_start();
        require realpath(__DIR__ . '/../Template/default.php');
        return new Response(ob_get_clean());
    }

    /**
     * Get routes in correct format for Vue Router.
     */
    private function getRoutes(): array
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
}