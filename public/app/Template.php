<?php

namespace Frontend;


class Template
{
    public static function render (string $pathToTemplate, array $vars)
    {
        ob_start();
        extract($vars);
        require $pathToTemplate;
        return ob_get_clean();
    }
}