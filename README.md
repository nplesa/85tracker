# nplesa/85tracker

Laravel 12 package that scans your application for  
potential issues when upgrading from **PHP 8.4 → PHP 8.5**, including:
- Detection of deprecated functions
- Auto-fixing deprecated usages
- Checking missing PHP extensions
- Optional runtime compatibility middleware
- CLI tools for scanning and fixing issues
- Developer-friendly helper utilities
- Fully configurable behavior

  
🚀 Instalation
```
composer require nplesa/85tracker
```

Publish config:
```
php artisan vendor:publish --tag=tracker-config
```
🧪 Test
```
php artisan tracker:scan
php artisan tracker:scan --fix
```

From code:
```
php85scanner()->scanProject();
php85scanner()->autoFix();
php85scanner()->checkExtensions();
```
Scan Output Example
```
Scanning project...
Deprecated functions found:
 - utf8_encode in app/Http/Controllers/Test.php
All required extensions are installed.
Done!
```
Autofix Output Example
```
Running autofix...
Fixed in app/Http/Controllers/Test.php
Fixed in app/Helpers/Format.php
Complete!
```


