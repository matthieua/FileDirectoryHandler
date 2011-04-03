<?php
/**
 * Created by PhpStorm.
 * User: Matthieu
 * Date: Apr 3, 2011
 * Time: 2:16:58 PM
 * To change this template use File | Settings | File Templates.
 */

class Dir {

  private $dirRoot = 'app';
  private $dirName;

  public function __construct($dirName) {
    $this->dirName = $dirName;
  }

  // Create the directory here
  public function create() {
    return mkdir($this->getFullPath(), '777');
  }

  public function isValid() {
    if (!$this->exists() && (!preg_match('/\s/', $this->dirName))) {
      return true;
    }
    return false;
  }


  private function exists() {
    if (is_dir($this->getFullPath())) {
      return true;
    }
    return false;
  }

  public function getDirName() {
    return $this->dirName;
  }

  public function setDirName($dirname) {
    $this->dirName = $dirname;
  }

  private function getFullPath() {
    return APP_ROOT . DS . $this->dirRoot . DS . $this->dirName;
  }

}
