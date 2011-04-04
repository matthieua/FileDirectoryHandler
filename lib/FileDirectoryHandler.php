<?php
/**
 * Created by PhpStorm.
 * User: Matthieu
 * Date: Apr 3, 2011
 * Time: 5:04:50 PM
 * To change this template use File | Settings | File Templates.
 */

require_once ('Dir.php');
require_once ('File.php');

class FileDirectoryHandler
{

    protected $name;
    protected $context;

    function __construct($name, $context = '')
    {
        $this->name = $name;
        $this->context = $context;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function setContext($context)
    {
        $this->context = $context;
    }

    public function getPath()
    {
        return (empty($this->context) ? $this->name : $this->context . DS . $this->name);
    }

    public function isDir()
    {
        return (is_dir($this->getPath()));
    }

    public function isFile()
    {
        return (is_file($this->getPath()));
    }

    public static function isHidden($name)
    {
        return (!preg_match('/^\./', $name));
    }
}
