<?php

namespace App\Services;

class ViteService
{
    protected $manifest = [];

    public function __construct()
    {
        $this->loadManifest();
    }

    protected function loadManifest()
    {
        // Путь к manifest.json, сгенерированному Vite
        $manifestPath = __DIR__ . '/../public/build/manifest.json';
        if (file_exists($manifestPath)) {
            $this->manifest = json_decode(file_get_contents($manifestPath), true);
        }
    }

    public function asset($key)
    {
        if (array_key_exists($key, $this->manifest)) {
            // Путь к сгенерированным файлам Vite
            return '/build/' . $this->manifest[$key]['file'];
        }

        return '';
    }
}