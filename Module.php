<?php

namespace KapitchiFileManager;

use KapitchiEntity\Mapper\EntityDbAdapterMapper,
    KapitchiEntity\Mapper\EntityDbAdapterMapperOptions,
    Zend\EventManager\EventInterface,
    Zend\ModuleManager\Feature\ControllerProviderInterface,
    Zend\ModuleManager\Feature\ServiceProviderInterface,
    Zend\ModuleManager\Feature\ViewHelperProviderInterface,
	KapitchiBase\ModuleManager\AbstractModule;

class Module extends AbstractModule implements ServiceProviderInterface, ControllerProviderInterface, ViewHelperProviderInterface
{

	public function onBootstrap(EventInterface $e) {
		parent::onBootstrap($e);
		
        
	}
    
    public function getViewHelperConfig() {
        return array(
            'invokables' => array(
                'FileManager' => 'KapitchiFileManager\View\Helper\AbstractFileManager',
            ),
            'factories' => array(
                'fileManagerFileIndex' => function($sm) {
                    $ins = new View\Helper\FileIndex(
                        $sm->getServiceLocator()->get('KapitchiFileManager\Service\FileIndex')
                    );
                    return $ins;
                }
            )
        );
    }
    
    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'KapitchiFileManager\Controller\Manager' => function($sm) {
                    $cont = new Controller\ManagerController();
                    return $cont;
                },
                'KapitchiFileManager\Controller\Downloader' => function($sm) {
                    $cont = new Controller\DownloaderController();
                    $cont->setFileManagerService($sm->getServiceLocator()->get('KapitchiFileManager\Service\FileManager'));
                    $cont->setFileIndexService($sm->getServiceLocator()->get('KapitchiFileManager\Service\FileIndex'));
                    return $cont;
                },
                //API
                'KapitchiFileManager\Controller\Api\FileIndex' => function($sm) {
                    $cont = new Controller\Api\FileIndexRestfulController(
                        $sm->getServiceLocator()->get('KapitchiFileManager\Service\FileIndex')
                    );
                    return $cont;
                }
            )
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'KapitchiFileManager\Entity\FileIndex' => 'KapitchiFileManager\Entity\FileIndex',
            ),
            'factories' => array(
                'KapitchiFileManager\Service\FileIndex' => function ($sm) {
                    $s = new Service\FileIndex(
                        $sm->get('KapitchiFileManager\Mapper\FileIndexDbAdapter'),
                        $sm->get('KapitchiFileManager\Entity\FileIndex'),
                        $sm->get('KapitchiFileManager\Entity\FileIndexHydrator')
                    );
                    return $s;
                },
                'KapitchiFileManager\Mapper\FileIndexDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'filemanager_file',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiFileManager\Entity\FileIndexHydrator'),
                            'entityPrototype' => $sm->get('KapitchiFileManager\Entity\FileIndex'),
                        ))
                    );
                },
                'KapitchiFileManager\Entity\FileIndexHydrator' => function ($sm) {
                    return new Entity\FileIndexHydrator(false);
                },
                        
                'KapitchiFileManager\Service\FileManager' => function ($sm) {
                    $ins = new Service\FileManager();
                    $ins->setVolumeManager($sm->get('KapitchiFileManager\Volume\Manager'));
                    $ins->setVolumeResolver($sm->get('KapitchiFileManager\Service\VolumeResolver'));
                    return $ins;
                },
                        
                'KapitchiFileManager\Service\VolumeResolver' => function ($sm) {
                    $ins = new Service\VolumePathPrefixResolver();
                    return $ins;
                },
                        
                'KapitchiFileManager\Volume\Manager' => function ($sm) {
                    $ins = new Volume\Manager();
                    //TODO move to config file -- using factories
                    $ins->setFactory('public', function ($sm) {
                        $options = new \KapitchiFileManager\Volume\LocalFilesystemVolumeOptions(array(
                            'label' => 'Public files',
                            'pathRoot' => './public/var/files',
                            //'urlRoot' => '/var/files'
                        ));
                        return new \KapitchiFileManager\Volume\LocalFilesystemVolume($options);
                    });
                    $ins->setFactory('protected', function ($sm) {
                        $options = new \KapitchiFileManager\Volume\LocalFilesystemVolumeOptions(array(
                            'label' => 'Protected files',
                            //'urlRoot' => '/file-manager/downloader',
                            'pathRoot' => './data/files'
                        ));
                        return new \KapitchiFileManager\Volume\LocalFilesystemVolume($options);
                    });
                    $ins->setFactory('cache', function ($sm) {
                        $options = new \KapitchiFileManager\Volume\LocalFilesystemVolumeOptions(array(
                            'label' => 'Cache',
                            'system' => true,
                            'pathRoot' => './data/cache'
                        ));
                        return new \KapitchiFileManager\Volume\LocalFilesystemVolume($options);
                    });
                    return $ins;
                },
            )
        );
    }
    
    public function getDir() {
        return __DIR__;
    }

    public function getNamespace() {
        return __NAMESPACE__;
    }

}