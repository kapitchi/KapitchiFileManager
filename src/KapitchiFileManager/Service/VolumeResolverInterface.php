<?php
namespace KapitchiFileManager\Service;

/**
 * 
 * @author Matus Zeman <mz@kapitchi.com>
 */
interface VolumeResolverInterface
{
    /**
     * Expected return:
     * return array(
            'volumeHandle' => $volumeHandle,
            'volumePath' => $volumePath
        );
     * @param type $path
     */
    public function parsePath($path);
    
    public function buildPath($volumeHandle, $path);
}