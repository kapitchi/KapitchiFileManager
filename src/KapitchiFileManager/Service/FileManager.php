<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiFileManager\Service;

use KapitchiBase\Service\AbstractService,
    KapitchiFileManager\Volume\Manager as VolumeManager;

/**
 * 
 * @author Matus Zeman <mz@kapitchi.com>
 */
class FileManager extends AbstractService
{
    protected $volumeManager;
    protected $volumeResolver;

    public function __destruct()
    {
        $this->unmountAll();
    }

    public function copy($fromPath, $toPath)
    {
        $fromVolumeData = $this->getVolumeResolver()->parsePath($fromPath);
        $toVolumeData = $this->getVolumeResolver()->parsePath($toPath);
        
        if($fromVolumeData['volumeHandle'] != $toVolumeData['volumeHandle']) {
            throw new \Exception("Copy not supported on different volumes, yet!");
        }
        
        //volumes are same
        $volume = $this->getVolume($fromVolumeData['volumeHandle']);
        $volume->copy($fromVolumeData['volumePath'], $toVolumeData['volumePath']);
        
        $this->triggerEvent('copy.post', array(
            'fromVolume' => $volume,
            'fromVolumeHandle' => $fromVolumeData['volumeHandle'],
            'fromVolumePath' => $fromVolumeData['volumePath'],
            'toVolume' => $volume,
            'toVolumeHandle' => $toVolumeData['volumeHandle'],
            'toVolumePath' => $toVolumeData['volumePath'],
        ));
        
    }
    
    public function ls($path, $sortOrder = null)
    {
        $volumeData = $this->getVolumeResolver()->parsePath($path);
        $volume = $this->getVolumeManager()->get($volumeData['volumeHandle']);
        
//        $res = $this->triggerEvent('ls', array(
//            'volume' => $volume,
//            'volumeHandle' => $volumeData['volumeHandle'],
//            'volumePath' => $volumeData['volumePath'],
//            'sortOrder' => $sortOrder,
//        ));
        
        //return $res;
        
        return $volume->ls($volumeData['volumePath'], $sortOrder);
    }

    public function read($path)
    {
        $volumeData = $this->getVolumeResolver()->parsePath($path);
        $volume = $this->getVolume($volumeData['volumeHandle']);
        return $volume->read($volumeData['volumePath']);
    }

    public function remove($path)
    {
        $volumeData = $this->getVolumeResolver()->parsePath($path);
        $volume = $this->getVolume($volumeData['volumeHandle']);
        $volume->remove($volumeData['volumePath']);
        
        $res = $this->triggerEvent('remove.pos', array(
            'volume' => $volume,
            'volumeHandle' => $volumeData['volumeHandle'],
            'volumePath' => $volumeData['volumePath'],
        ));
    }

    public function rename($fromPath, $toPath)
    {
        $fromVolumeData = $this->getVolumeResolver()->parsePath($fromPath);
        $toVolumeData = $this->getVolumeResolver()->parsePath($toPath);
        
        if($fromVolumeData['volumeHandle'] != $toVolumeData['volumeHandle']) {
            throw new \Exception("Rename not supported on different volumes, yet!");
        }
        
        //volumes are same
        $volume = $this->getVolume($fromVolumeData['volumeHandle']);
        $volume->rename($fromVolumeData['volumePath'], $toVolumeData['volumePath']);
        
        $this->triggerEvent('rename', array(
            'fromVolume' => $volume,
            'fromVolumeHandle' => $fromVolumeData['volumeHandle'],
            'fromVolumePath' => $fromVolumeData['volumePath'],
            'toVolume' => $volume,
            'toVolumeHandle' => $toVolumeData['volumeHandle'],
            'toVolumePath' => $toVolumeData['volumePath'],
        ));
    }

    public function store($path, $content)
    {
        $volumeData = $this->getVolumeResolver()->parsePath($path);
        $volume = $this->getVolume($volumeData['volumeHandle']);
        
        $volume->store($volumeData['volumePath']);
        
        $res = $this->triggerEvent('store.post', array(
            'volume' => $volume,
            'volumeHandle' => $volumeData['volumeHandle'],
            'volumePath' => $volumeData['volumePath'],
            'content' => $content,
        ));
    }
    
    public function storeFile($path, $filePath)
    {
        $volumeData = $this->getVolumeResolver()->parsePath($path);
        $volume = $this->getVolume($volumeData['volumeHandle']);
        
        $volume->storeFile($volumeData['volumePath'], $filePath);
        
        $res = $this->triggerEvent('storeFile.post', array(
            'volume' => $volume,
            'volumeHandle' => $volumeData['volumeHandle'],
            'volumePath' => $volumeData['volumePath'],
            'filePath' => $filePath,
        ));
    }
    
    public function getFileMeta($path) {
        $volumeData = $this->getVolumeResolver()->parsePath($path);
        $volume = $this->getVolume($volumeData['volumeHandle']);
        
        //TODO
    }

    protected function getVolume($handle)
    {
        return $this->getVolumeManager()->get($handle);
    }
    
    /**
     * 
     * @return \KapitchiFileManager\Volume\Manager
     */
    public function getVolumeManager()
    {
        return $this->volumeManager;
    }

    public function setVolumeManager(VolumeManager $volumeManager)
    {
        $this->volumeManager = $volumeManager;
    }
    
    /**
     * 
     * @return VolumeResolverInterface
     */
    public function getVolumeResolver()
    {
        return $this->volumeResolver;
    }

    public function setVolumeResolver($volumeResolver)
    {
        $this->volumeResolver = $volumeResolver;
    }
}