<?php

function load($class)
{
    $classPrefix = strtolower($class);
    $classPath = APP_PATH . C("common", "class_path") . DIRECTORY_SEPARATOR;
    $classSuffix = C("common", "class_suffix");
    $classFile = $classPath . $classPrefix . $classSuffix;
    require_once $classFile;
}

spl_autoload_register("load");
?>