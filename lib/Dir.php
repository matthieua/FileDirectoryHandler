<?php
/**
 * Created by matthieu.
 * User: matthieu
 * Date: 4/04/11
 * Time: 2:33 PM
 */
 

class Dir extends FileDirectoryHandler
{
    public function create()
    {
        return mkdir($this->getPath(), 0777, true);
    }

    public function delete()
    {
        return rmdir($this->getPath());
    }

    public function exists()
    {
        return is_dir($this->getPath());
    }


    public function getDirListing()
    {
        $dirRootListing = array();

        $dir = opendir($this->getPath());

        // get each entry
        while ($entryName = readdir($dir)) {
            $dirRootListing[] = $entryName;
        }

        closedir($dir);

        // Filter only directories
        $dirRootListing = array_filter($dirRootListing, 'FileDirectoryHandler::isHidden');
        sort($dirRootListing);
        return $dirRootListing;
    }
}
