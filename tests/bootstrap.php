<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

// Manually load the .env.test file for testing environment
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env.test');