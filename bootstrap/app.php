<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
(\Dotenv\Dotenv::create(__DIR__ . '/../'))->load();

return App\Core\Application::getInstance();
