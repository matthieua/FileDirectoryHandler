<?php
/**
 * Created by PhpStorm.
 * User: Matthieu
 * Date: Apr 3, 2011
 * Time: 4:50:01 PM
 * To change this template use File | Settings | File Templates.
 */

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
