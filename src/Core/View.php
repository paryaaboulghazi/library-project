<?php

namespace Src\Core;

class View
{
    public static function render(string $view, array $data = []): string
    {
        $viewFilePath = __DIR__ . '/../Views/' . $view . '.php';
    
        if (!file_exists($viewFilePath)) {
            throw new \Exception("View file not found: $view");
        }

        extract($data);
        ob_start();
        include $viewFilePath;
        return ob_get_clean();
    }
    
}