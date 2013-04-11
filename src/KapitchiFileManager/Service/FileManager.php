<?php
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

    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        $em = $this->getEventManager();
        $em->attach('copy', function($e) {
            //we do not support different volume copying
            $volume = $e->getParam('fromVolume');
            $volume->copy($e->getParam('fromVolumePath'), $e->getParam('toVolumePath'));
        });
        
        $em->attach('rename', function($e) {
            //we do not support different volume copying
            $volume = $e->getParam('fromVolume');
            $volume->rename($e->getParam('fromVolumePath'), $e->getParam('toVolumePath'));
        });
        
        $em->attach('remove', function($e) {
            //we do not support different volume copying
            $volume = $e->getParam('volume');
            $volume->remove($e->getParam('volumePath'));
        });
        
        $em->attach('store', function($e) {
            //we do not support different volume copying
            $volume = $e->getParam('volume');
            $volume->store($e->getParam('volumePath'), $e->getParam('content'));
        });
//        $em->attach('ls', function($e) {
//            $volume = $e->getParam('volume');
//            return $volume->ls($e->getParam('volumePath'), $e->getParam('sortOrder'));
//        });
    }
    
    public function copy($fromPath, $toPath)
    {
        $fromVolumeData = $this->getVolumeResolver()->parsePath($fromPath);
        $toVolumeData = $this->getVolumeResolver()->parsePath($toPath);
        
        if($fromVolumeData['volumeHandle'] != $toVolumeData['volumeHandle']) {
            throw new \Exception("Copy not supported on different volumes, yet!");
        }
        
        //volumes are same
        $volume = $this->getVolumeManager()->get($fromVolumeData['volumeHandle']);
        
        $this->triggerEvent('copy', array(
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
        $volume = $this->getVolumeManager()->get($volumeData['volumeHandle']);
        return $volume->read($volumeData['volumePath']);
    }

    public function remove($path)
    {
        $volumeData = $this->getVolumeResolver()->parsePath($path);
        $volume = $this->getVolumeManager()->get($volumeData['volumeHandle']);
        
        $res = $this->triggerEvent('remove', array(
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
        $volume = $this->getVolumeManager()->get($fromVolumeData['volumeHandle']);
        
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
        $volume = $this->getVolumeManager()->get($volumeData['volumeHandle']);
        
        $res = $this->triggerEvent('store', array(
            'volume' => $volume,
            'volumeHandle' => $volumeData['volumeHandle'],
            'volumePath' => $volumeData['volumePath'],
            'content' => $content,
        ));
    }
    
    public function getFileMeta($path) {
        $volumeData = $this->getVolumeResolver()->parsePath($path);
        $volume = $this->getVolumeManager()->get($volumeData['volumeHandle']);
        
        //TODO
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