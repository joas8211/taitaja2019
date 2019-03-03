<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\VueRenderer;

class PageController extends AbstractController
{
    public function show(Request $request, VueRenderer $renderer) {
        return new Response($renderer->render());
    }
}