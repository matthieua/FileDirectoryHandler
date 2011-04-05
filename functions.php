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
    // Divide the class name
    $pathAr = explode('\\', strtolower($className));

    $classPath = LIB_PATH . DS;
    $nPathAr = count($pathAr);
    foreach($pathAr as $key => $path)
    {
        $classPath .= (($key + 1) != $nPathAr) ? $path . DS : ucfirst($path) . '.php';
    }

    if (file_exists($classPath))
    {
        require_once($classPath);
    }
    else
    {
        die("The class {$class_name} could not be found.");
    }
}


