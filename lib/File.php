<?php
/**
 * Created by PhpStorm.
 * User: Matthieu
 * Date: Apr 3, 2011
 * Time: 4:50:01 PM
 * To change this template use File | Settings | File Templates.
 */

class File extends FileDirectoryHandler{

  private $content;

  public function __construct($name, $content = '') {
    $this->name = $name;
    if (!empty($content)) $this->content = $content;
  }

  public function create() {
    return file_put_contents(parent::getDirRootFullPath() . DS . $this->name, $this->content);
  }

  public function delete() {
    return unlink(Dir::getDirRootFullPath() . DS . $this->name);
  }

  public function exists() {
    return is_file(Dir::getDirRootFullPath() . DS . $this->name);
  }

  public function getContent() {
    return $this->content;
  }

  public function setContent($content) {
    $this->content = $content;  
  }

 
}
