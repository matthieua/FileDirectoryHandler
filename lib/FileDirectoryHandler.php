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

class FileDirectoryHandler {

  protected $name;

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public static function isHidden($name) {
    return (!preg_match('/^\./', $name));
  }

  public static function isDir($name) {
    return (is_dir(self::getDirRootFullPath() . DS . $name));
  }

  public static function isFile($name) {
    return (is_file(self::getDirRootFullPath() . DS . $name));
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

    closedir($dir);

    // Filter only directories
    $dirRootListing = array_filter($dirRootListing, 'Dir::isHidden');
    sort($dirRootListing);
    return $dirRootListing;
  }


}
