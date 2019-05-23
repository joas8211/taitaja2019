<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\VueRenderer;

class IndexController extends PageController
{
    public function show(Request $request, VueRenderer $renderer) {
        $this->vars['asd'] = 'test';
        return parent::show($request, $renderer);
    }
}