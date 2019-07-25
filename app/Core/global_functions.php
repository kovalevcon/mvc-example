<?php

if (!function_exists('app')) {
    function app(string $dispatch = null)
    {
        /** @var App\Core\Application $core */
        $core = App\Core\Application::getInstance();
        return $core->dispatch($dispatch);
    }
}

if (!function_exists('db')) {
    function db(): \App\Core\Database\Database
    {
        return app('database');
    }
}
