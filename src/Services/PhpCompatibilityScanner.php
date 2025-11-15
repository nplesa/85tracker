<?php

namespace nplesa\Tracker\Services;

class PhpCompatibilityScanner
{
    protected array $deprecatedFunctions;
    protected array $requiredExtensions;

    public function __construct()
    {
        $this->deprecatedFunctions = config('tracker.deprecated_functions', []);
        $this->requiredExtensions = config('tracker.required_extensions', []);
    }

    public function scanProject(): array
    {
        $results = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(base_path())
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $content = file_get_contents($file->getPathname());

                foreach ($this->deprecatedFunctions as $fn => $replacement) {
                    if (preg_match("/\b{$fn}\s*\(/", $content)) {
                        $results[] = [
                            'file' => $file->getPathname(),
                            'function' => $fn,
                            'replacement' => $replacement
                        ];
                    }
                }
            }
        }

        return $results;
    }

    public function checkExtensions(): array
    {
        return array_filter($this->requiredExtensions, fn($ext) =>
            !extension_loaded($ext)
        );
    }

    public function autoFix(): array
    {
        $fixed = []; // array pentru fișierele modificate

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(base_path())
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $original = $content = file_get_contents($file->getPathname());

                foreach ($this->deprecatedFunctions as $fn => $replacement) {
                    $content = preg_replace(
                        "/\b{$fn}\s*\((.*?)\)/",
                        $replacement,
                        $content
                    );
                }

                if ($content !== $original) {
                    file_put_contents($file->getPathname(), $content);
                    // Adăugăm calea fișierului în array-ul de modificate
                    $fixed[] = $file->getPathname();
                }
            }
        }
        return $fixed; // întotdeauna returnează un array
    }
}
