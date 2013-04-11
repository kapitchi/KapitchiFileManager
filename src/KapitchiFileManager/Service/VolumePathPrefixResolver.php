<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

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