<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiFileManager\Volume;

use Zend\Stdlib\ErrorHandler;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class LocalFilesystemVolume extends AbstractVolume implements StreamVolumeInterface
{
    public function getAbsPath($path) {
        $rootPath = $this->getOptions()->getPathRoot();
        $absPath = realpath($rootPath) . '/' . $path;
//        if($absPath === false) {
//            throw new \Exception("Can't get absolute file path for '$path'");
//        }
        return $absPath;
    }
    
    protected function isDir($absPath) {
        return is_dir($absPath);
    }
    
    public function createDir($path)
    {
        $absPath = $this->getAbsPath($path);
        if($this->isDir($absPath)) {
            return;
        }
        
        mkdir($absPath, 0777, true);
    }
    
    public function mount(Manager $manager)
    {
        $path = $this->getOptions()->getPathRoot();
        if(!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }
    
    public function unmount(Manager $manager)
    {
        //do nothing for local file system
    }
    
    public function copy($fromPath, $toPath)
    {
        ErrorHandler::start();
        copy($this->getAbsPath($fromPath), $this->getAbsPath($toPath));
        ErrorHandler::stop(true);
    }
    
    /**
     * 
     * @param string $path
     * @param type $sortOrder - TODO
     * @throws NotDirectoryException - if not directory
     */
    public function ls($path, $sortOrder = null)
    {
        $absPath = $this->getAbsPath($path);
        if(!$this->isDir($absPath)) {
            throw new Exception\NotDirectoryException("Path is not a directory: '$absPath'");
        }
        return scandir($absPath);
    }
    

    public function read($path)
    {
        $absPath = $this->getAbsPath($path);
        \Zend\Stdlib\ErrorHandler::start(E_WARNING | E_NOTICE);
        $cont = file_get_contents($absPath);
        \Zend\Stdlib\ErrorHandler::stop(true);
        return $cont;
    }
    
    public function remove($path)
    {
        $absPath = $this->getAbsPath($path);
        unlink($absPath);
    }
    
    public function rename($fromPath, $toPath)
    {
        rename($this->getAbsPath($fromPath), $this->getAbsPath($toPath));
    }
    
    public function store($path, $data)
    {
        $absPath = $this->getAbsPath($path);
        file_put_contents($absPath, $data);
    }
    
    public function storeFile($path, $filePath)
    {
        copy($filePath, $this->getAbsPath($path));
    }

    public function openStream($path)
    {
        $absPath = $this->getAbsPath($path);
        return fopen($absPath, "r");
    }
    
    public function closeStream($resource)
    {
        fclose($resource);
    }

    
}