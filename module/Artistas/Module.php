<?php


namespace Artistas;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\MvcEvent;
use Artistas\Model\Entity\Artista;
use Artistas\Model\Dao\ArtistaDao;


class Module implements AutoloaderProviderInterface, ServiceProviderInterface {
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

    }
    
    
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Artistas\Model\Dao\ArtistaDao' => function($sm){
                    $tableGateway = $sm->get('ArtistaTableGateway');
                    $dao = new ArtistaDao($tableGateway);
                    return $dao;
                },
                'ArtistaTableGateway' => function ($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Artista());
                    return new TableGateway('artista',$dbAdapter,null,$resultSetPrototype);
                },
            ),
            
        );
        
    }
        
}

