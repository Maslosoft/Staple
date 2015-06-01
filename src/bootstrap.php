<?php

use Maslosoft\Staple\Staple;
use Maslosoft\Staple\Request\HttpRequest;

// Place this file in http root and include in index.php
// NOTE: This file might be overridden upon update

require __DIR__ . '/vendor/autoload.php';

echo (new Staple)->handle(new HttpRequest);
