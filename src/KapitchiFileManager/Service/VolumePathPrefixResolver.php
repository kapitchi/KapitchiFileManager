<?php

namespace KapitchiFileManager\Service;
/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class VolumePathPrefixResolver implements VolumeResolverInterface
{
    
    public function parsePath($path)
    {
        //trim first forward slash
        $path = substr($path, 1);
        
        $paths = explode('/', $path);
        $volumeHandle = array_shift($paths);
        
        if(empty($volumeHandle)) {
            throw new \Exception("Empty volumeId?");
        }
        $volumePath = implode('/', $paths);
        
        return array(
            'volumeHandle' => $volumeHandle,
            'volumePath' => $volumePath
        );
    }
    
    public function buildPath($volumeHandle, $path) {
        return "/$volumeHandle/$path";
    }
    
}