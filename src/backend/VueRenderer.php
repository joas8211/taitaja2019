<?php

namespace App;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Service for rendering Vue.js page component.
 */
class VueRenderer
{
    private $publicRoot;
    private $router;

    public function __construct(KernelInterface $kernel, RouterInterface $router)
    {
        $this->publicRoot = realpath($kernel->getProjectDir().'/../../public');
        $this->router = $router;
    }

    /**
     * Render page preferring JS render.
     */
    public function render()
    {
        
    }
}