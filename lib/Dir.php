<?php
/**
 * Created by PhpStorm.
 * User: Matthieu
 * Date: Apr 3, 2011
 * Time: 2:16:58 PM
 * To change this template use File | Settings | File Templates.
 */

class Dir {

  private $dirName;

  public function __construct($dirName) {
    $this->dirName = $dirName;
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

  public function getDirName() {
    return $this->dirName;
  }

  public function setDirName($dirname) {
    $this->dirName = $dirname;
  }

  public function getDirFullPath() {
    return self::getDirRootFullPath() . DS . $this->dirName;
  }


  public static function getDirRootFullPath() {
    return PATH_ROOT . DS . APP_ROOT_DIR;
  }

  public static function getDirListing($path) {
    $dirRootListing = array();
    $dir = opendir($path);

    // get each entry
    while ($entryName = readdir($dir)) {
      $dirRootListing[] = $entryName;
    }

    // Filter only directories
    $dirRootListing = array_filter($dirRootListing, 'Dir::isDir');
    $dirRootListing = array_filter($dirRootListing, 'Dir::isHidden');
    sort($dirRootListing);
    return $dirRootListing;
  }

  public static function isDir($name) {
    return (is_dir(Dir::getDirRootFullPath() . DS . $name));
  }

  public static function isHidden($name) {
    return (!preg_match('/^\./', $name));
  }
}
