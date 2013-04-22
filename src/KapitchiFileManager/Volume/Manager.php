<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiFileManager\Volume;

use Zend\ServiceManager\AbstractPluginManager;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Manager extends AbstractPluginManager
{
    
    public function __destruct()
    {
        $this->unmountAll();
    }

    public function get($name)
    {
        $name = $this->canonicalizeName($name);
        $instance = parent::get($name);
        if(!$instance->getId()) {
            $instance->setId($name);
            
            $instance->mount($this);
        }
        
        return $instance;
    }
    
    public function unregisterService($name)
    {
        $instance = parent::get($name);
        $instance->unmount($this);
        
        parent::unregisterService($name);
    }
    
    public function unmountAll()
    {
        foreach($this->instances as $ins) {
            $ins->unmount($this);
        }
    }
    
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof VolumeInterface) {
            return;
        }

        throw new \Exception(sprintf(
            'Plugin of type %s is invalid; must implement %s\VolumeInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }
}