<?php
/**
 * Created by matthieu.
 * Date: 5/04/11
 * Time: 8:50 PM
 */
namespace misc;

class Autoloader
{
    private $path;

    /**
     * @static
     * @return string Return the autoloader path
     */
    private function getPath()
    {
        return $this->path;
    }


    /**
     * @static set the autoloader path
     * @param  string $path autoload path
     */
    private function setPath($path)
    {
        $this->path = $path;
    }


    /**
     * @static
     * @param  $className
     * @return error if the class could not be fine
     */
    public function autoload($className)
    {
        // Determine if the class is already loaded
        if (class_exists($className)) return false;

        // Separate the path
        $pathAr = explode('\\', $className);

        // Get the path
        $classPath = $this->path . DS;
        $nPathAr = count($pathAr);
        foreach ($pathAr as $key => $path)
        {
            $classPath .= (($key + 1) != $nPathAr) ?  $path . DS : $path .'.php';
        }

        // Check if the file exists
        if (file_exists($classPath)) {
            require_once($classPath);
        }
        else
        {
            die("The class {$className} could not be found.");
        }
    }

    /**
     * Register the autoloader
     * @param  string $path root path
     */
    public function registerAutoload($path)
    {
        $this->setPath($path);
        spl_autoload_register(array($this, 'autoload'));
    }

}
