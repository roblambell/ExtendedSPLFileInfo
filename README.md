ExtendedSPLFileInfo
===================

PHP class extends SPLFileInfo

Methods
-----

* getDirSize() - size of directory contents (recursive) or parent directory if isFile

* getFileMTime() - MTime of most recent directory contents (recursive) or file if isFile

* getHumanSize() - human readable filesize, %.2f {$factor}. default from $this->getSize()

Usage
------------

```php
$iterator = new FilesystemIterator(dirname(__FILE__));
$iterator->setInfoClass('ExtendedSPLFileInfo');
foreach ($iterator as $file) {
	echo $file->getFileMTime() . PHP_EOL;
}