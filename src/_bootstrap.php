<?php

use Maslosoft\Staple\Staple;
use Maslosoft\Staple\Request\HttpRequest;

// Include this file in http root's index.php, ie.:
// require __DIR__ . '/index.php';
// NOTE: This file might be overridden upon update

require __DIR__ . '/vendor/autoload.php';

echo Staple::fly(__DIR__)->handle(new HttpRequest);
