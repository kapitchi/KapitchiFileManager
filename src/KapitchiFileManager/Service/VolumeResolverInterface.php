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