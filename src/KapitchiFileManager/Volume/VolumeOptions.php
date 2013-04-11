<?php

namespace KapitchiFileManager\Volume;

class VolumeOptions extends \Zend\Stdlib\AbstractOptions {
    protected $system = false;
    protected $label;
    //e.g. /file-manager/downloader
    protected $urlRoot;
    //e.g. '?path=%1$s'
    protected $urlPathFormat;
    
    public function getLabel()
    {
        if(empty($this->label)) {
            $this->label = basename($this->getUrlRoot());
        }
        
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getUrlRoot()
    {
        return $this->urlRoot;
    }

    public function setUrlRoot($urlRoot)
    {
        $this->urlRoot = $urlRoot;
    }

    public function getUrlPathFormat()
    {
        return $this->urlPathFormat;
    }

    public function setUrlPathFormat($urlPathFormat)
    {
        $this->urlPathFormat = $urlPathFormat;
    }
    
    public function getSystem()
    {
        return $this->system;
    }

    public function setSystem($system)
    {
        $this->system = $system;
    }
    
}