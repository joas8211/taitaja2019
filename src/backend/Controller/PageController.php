<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\VueRenderer;

class PageController extends AbstractController
{
    public $vars = [];

    public function show(Request $request, VueRenderer $renderer)
    {
        $routeParams = $request->attributes->get('_route_params');
        $viewId = $routeParams['view'];

        // Get logged in user
        $this->vars['user'] = $_SESSION['user'] ?? false;

        // Define scripts
        $scripts = [];
        $scripts[] = [
            'content' => 'window._page_ = ' . json_encode($viewId),
        ];
        $scripts[] = [
            'content' => 'window._vars_ = ' . json_encode($this->vars),
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
}