<?php

namespace nplesa\Tracker\Commands;

use Illuminate\Console\Command;
use nplesa\Tracker\Services\PhpCompatibilityScanner;

class ScanCompatibility extends Command
{
    protected $signature = 'tracker:scan {--fix}';
    protected $description = 'Scan Laravel project for PHP 8.5 compatibility';

    public function handle(PhpCompatibilityScanner $scanner)
    {
        $this->info("Scanning project...");

        $results = $scanner->scanProject();
        $missing = $scanner->checkExtensions();

        if ($results) {
            $this->warn("Deprecated functions found:");
            foreach ($results as $r) {
                $this->line(" - {$r['function']} in {$r['file']} (replace with {$r['replacement']})");
            }
        } else {
            $this->info("No deprecated functions found.");
        }

        if ($missing) {
            $this->error("Missing PHP extensions: " . implode(', ', $missing));
        } else {
            $this->info("All required extensions are installed.");
        }

        if ($this->option('fix')) {
            $this->info("🔧 Running autofix...");
            $fixed = $scanner->autoFix();
            foreach ($fixed as $file) {
                $this->line("Fixed: {$file}");
            }
        }

        $this->info("Done!");
    }
}
