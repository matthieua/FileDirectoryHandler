<?php

/**
 * @return string Application folder path
 */
function  getAppFullPath()
{
    return PATH_ROOT . DS . APP_ROOT_DIR;
}

function __autoload($className)
{

    // Determine if the class is already loaded
    if (class_exists($className)) return false;

    // Separate the path
    $pathAr = explode('\\', strtolower($className));

    // Get the path
    $classPath = LIB_PATH . DS;
    $nPathAr = count($pathAr);
    foreach($pathAr as $key => $path)
    {
        $classPath .= (($key + 1) != $nPathAr) ? $path . DS : ucfirst($path) . '.php';
    }

    // Check if the file exists
    if (file_exists($classPath))
    {
        require_once($classPath);
    }
    else
    {
        die("The class {$className} could not be found.");
    }
}


