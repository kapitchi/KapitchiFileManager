<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiFileManager\Entity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class FileIndex
{
    const TYPE_FILE = 'file';
    const TYPE_DIR = 'dir';
    
    protected $id;
    
    protected $volumeId;
    protected $hash;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * Relative volume path
     * @var string
     */
    protected $path;
    
    /**
     * Directory/file/??? TODO
     * @var type TODO
     */
    protected $type;
    
    /**
     * @var int Size in bytes
     */
    protected $size;
    
    /**
     * mime type - http://en.wikipedia.org/wiki/Internet_media_type
     * @var string
     */
    protected $mime;
    
    //protected $attrs = array();//hidden, ...?
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getVolumeId()
    {
        return $this->volumeId;
    }

    public function setVolumeId($volumeId)
    {
        $this->volumeId = $volumeId;
    }
    
    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }
        
    public function getName()
    {
//        if($this->name === null) {
//            $path = $this->getPath();
//            $this->name = substr(strrchr($path, '/'), 1);
//        }
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getMime()
    {
        return $this->mime;
    }

    public function setMime($mime)
    {
        $this->mime = $mime;
    }

//    public function getAttrs()
//    {
//        return $this->attrs;
//    }
//
//    public function setAttrs($attrs)
//    {
//        $this->attrs = $attrs;
//    }


}