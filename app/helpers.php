<?php
if (!function_exists('modules_path')) {
    function modules_path($path = '')
    {
        return app()->basePath() . '/modules/' . $path;
    }
}
