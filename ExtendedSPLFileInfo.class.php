<?php
/**
 * ExtendedSPLFileInfo
 *
 * (c) 2014 Rob Lambell <rob[at]lambell.info>
 * This code is licensed under MIT license (see LICENSE for details)
 */

class ExtendedSPLFileInfo extends SPLFileInfo
{
    /**
     * @param $filename
     */
    public function __construct($filename) {
        parent::__construct($filename);
    }

    /**
     * @return int
     */
    function getDirSize()
    {
        if ($this->isDir()) {
            $path = $this->getPathname();
        } else {
            $path = $this->getPath();
        }

        $size = 0;
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS));
        foreach($files as $file){
            $size += $file->getSize();
        }
        return $size;
    }

    /**
     * @return int
     */
    function getFileMTime()
    {
        if ($this->isDir()) {
            $path = $this->getPathname();
        } else {
            return $this->getMTime();
        }

        $lastModified = 0;
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS));
        foreach ($files as $file) {
            if ($file->getMTime() > $lastModified) {
                $lastModified = $file->getMTime();
            }
        }

        if ($lastModified < 1) {
            $lastModified = $this->getMTime();
        }

        return $lastModified;
    }

    /**
     * @param bool $bytes
     * @param int  $decimals
     * @return string
     */
    public function getHumanSize($bytes = false, $decimals = 2)
    {
        $bytes = $bytes ? $bytes : $this->getSize();

        $size = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f ", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

}
