<?php
namespace KapitchiFileManager\Volume;

use Zend\ServiceManager\AbstractPluginManager;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Manager extends AbstractPluginManager
{
    
    public function __construct(ConfigInterface $config = null)
    {
        parent::__construct($config);
        //$this->addInitializer(array($this, 'injectRenderer'));
    }
    
    public function __destruct()
    {
        foreach($this->getCanonicalNames() as $name) {
            $this->unregisterService($name);
        }
    }

    public function create($name)
    {
        if (is_array($name)) {
            list($cName, $rName) = $name;
        } else {
            $rName = $name;
            $cName = $this->canonicalizeName($rName);
        }

        $instance = parent::create($name);
        
        $instance->setId($cName);
        $instance->mount($this);
        
        return $instance;
    }
    
    public function unregisterService($name)
    {
        $instance = $this->get($name);
        $instance->unmount($this);
        
        parent::unregisterService($name);
    }
    
//    public function injectRenderer($helper)
//    {
//        $renderer = $this->getRenderer();
//        if (null === $renderer) {
//            return;
//        }
//        $helper->setView($renderer);
//    }
    
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