<?php
/**
 * Created by matthieu.
 * User: matthieu
 * Date: 4/04/11
 * Time: 2:33 PM
 */
namespace filesystem;

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
        return (empty($this->context) ? $this->name : $this->context . DIRECTORY_SEPARATOR . $this->name);
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
