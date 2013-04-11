<?php
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