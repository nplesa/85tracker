<?php

return [

    'middleware_enabled' => false,

    'required_extensions' => [
        'intl',
        'mbstring',
        'openssl',
        'pdo',
        'curl',
        'json',
    ],

    'deprecated_functions' => [
        'utf8_encode' => 'mb_convert_encoding($1, "UTF-8")',
        'utf8_decode' => 'mb_convert_encoding($1, "ISO-8859-1")',
        'money_format' => 'NumberFormatter',
    ],

];
