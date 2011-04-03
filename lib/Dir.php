<?php
/**
 * Created by PhpStorm.
 * User: Matthieu
 * Date: Apr 3, 2011
 * Time: 2:16:58 PM
 * To change this template use File | Settings | File Templates.
 */

class Dir extends FileDirectoryHandler {

  public function __construct($name) {
    $this->name = $name;
  }

  public function create() {
    return mkdir($this->getDirFullPath(), '0777', 1);
  }

  public function delete() {
    return rmdir($this->getDirFullPath());
  }

  public function exists() {
    return is_dir($this->getDirFullPath()) ? true : false;
  }

  public function getDirFullPath() {
    return parent::getDirRootFullPath() . DS . $this->name;
  }
  
}
