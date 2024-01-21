<?php

namespace App\Controllers;

use Jenssegers\Blade\Blade;

class BaseController
{
    protected $blade;

    public function __construct()
    {
        // Paths to folders with templates and cache
        $views = __DIR__ . '/../resources/views';
        $cache = __DIR__ . '/../bootstrap/cache';

        // Create a Blade instance
        $this->blade = new Blade($views, $cache);
    }

    protected function view($view, $data = [])
    {
        echo $this->blade->make($view, $data)->render();
    }
}
