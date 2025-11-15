<?php

use nplesa\Tracker\Services\PhpCompatibilityScanner;

if (!function_exists('php85scanner')) {
    function php85scanner(): PhpCompatibilityScanner
    {
        return app(PhpCompatibilityScanner::class);
    }
}
