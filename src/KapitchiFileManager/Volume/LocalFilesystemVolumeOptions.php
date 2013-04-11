<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiFileManager\Volume;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class LocalFilesystemVolumeOptions extends VolumeOptions
{
    protected $pathRoot;
    
    public function getPathRoot()
    {
        return $this->pathRoot;
    }

    public function setPathRoot($pathRoot)
    {
        $this->pathRoot = $pathRoot;
    }

}