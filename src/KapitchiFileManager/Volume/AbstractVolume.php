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
abstract class AbstractVolume implements VolumeInterface
{
    protected $id;
    protected $options;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function __construct($options)
    {
        $this->setOptions($options);
    }
    
    /**
     * @return VolumeOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(VolumeOptions $options)
    {
        $this->options = $options;
    }
    
    public function getUrlPath($volumeId, $path) {
        $root = $this->getOptions()->getUrlRoot();
        $format = $this->getOptions()->getUrlPathFormat();
        $url = sprintf($format, $path);
        $url = str_replace('//', '/', $url);
        return $url;
    }

}