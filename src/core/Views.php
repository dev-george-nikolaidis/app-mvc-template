<?php

declare(strict_types=1);

namespace Src\core;

use Src\core\ErrorHandler;
use Src\helpers\Debugger;

class Views
{
    public function renderView(string $view, array $data = []): void
    {
        $viewFile = $this->getViewFilePath($view);
        // Debugger::dd("Rendering view $viewFile");
        if (file_exists($viewFile)) {
            // Extract the data array into variables for easier use in the view
            extract($data);

            // Start output buffering to capture the content of the included file
            ob_start();

            try {
                // Include the view file
                include $viewFile;
            } catch (\Exception $e) {
                ob_end_clean(); // Discard the output buffer in case of an exception
                ErrorHandler::internalServerError("Error rendering view $view: " . $e->getMessage());
                return;
            }

            // Get the content of the included file from the output buffer
            $content = ob_get_clean();

            // Check for nested views with folders
            $nestedViews = $this->extractNestedViews($content);

            // Recursively render nested views
            foreach ($nestedViews as $nestedView) {
                $this->renderView($nestedView, $data);
            }

            // Output the main content
            echo $content;
        } else {
            ErrorHandler::internalServerError("View $view not found.");
        }
    }

    private function getViewFilePath(string $view): string
    {
        $parts = explode('/', $view);
        $parts = array_map('ucfirst', $parts);

        $path = __DIR__ . '/../views/' . implode('/', $parts) . '.php';

        return $path;
    }

    private function extractNestedViews(string $content): array
    {
        $nestedViews = [];

        // Use a regular expression to find occurrences of '{{ folder/viewName }}'
        preg_match_all('/\{\{\s*([a-zA-Z0-9_\/-]+)\s*\}\}/', $content, $matches);

        // Extract the view names from the matches
        if (!empty($matches[1])) {
            $nestedViews = $matches[1];
        }

        return $nestedViews;
    }
}
