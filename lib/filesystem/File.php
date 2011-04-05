<?php
/**
 * Created by matthieu.
 * User: matthieu
 * Date: 4/04/11
 * Time: 2:33 PM
 */
namespace filesystem;

class File extends FileDirectoryHandler
{
    private $content;

    public function __construct($name, $context = '', $content = '')
    {
        parent::__construct($name, $context);
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function create()
    {
        return file_put_contents($this->getPath(), $this->content);
    }

    public function delete()
    {
        return unlink($this->getPath());
    }

    public function exists()
    {
        return is_file($this->getPath());
    }
}
