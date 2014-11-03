<?php


namespace Obras;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Obras\Model\Entity\Estilo;
use Obras\Model\Entity\Obra;
use Obras\Model\Entity\TipoObra;
use Obras\Model\Dao\EstiloDao;
use Obras\Model\Dao\ObraDao;
use Obras\Model\Dao\TipoObraDao;


class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig() {
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

//    public function getControllerConfig(){
//        return array(
//            'factories' => array (
//                'Obras\Controller\Obras' => function ($sm){
//                    $controller = new \Obras\Controller\ObrasController();
//                    $locator = $sm->getServiceLocator();
//                    $controller->setObraDao($locator->get('Obras\Model\Dao\ObraDao'));
//                    return $controller;
//                }
//            )
//        );
//    }
    
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e) {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Obras\Model\Dao\EstiloDao' => function($sm){
                    $tableGateway = $sm->get('EstiloTableGateway');
                    $dao = new EstiloDao($tableGateway);
                    return $dao;
                },
                'EstiloTableGateway' => function ($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Estilo());
                    return new TableGateway('estilo',$dbAdapter,null,$resultSetPrototype);
                },
                'Obras\Model\Dao\ObraDao' => function($sm){
                    $tableGateway = $sm->get('ObraTableGateway');
                    $dao = new ObraDao($tableGateway);
                    return $dao;
                },
                'ObraTableGateway' => function ($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Obra());
                    return new TableGateway('obra',$dbAdapter,null,$resultSetPrototype);
                },
                'Obras\Model\Dao\TipoObraDao' => function($sm){
                    $tableGateway = $sm->get('TipoObraTableGateway');
                    $dao = new TipoObraDao($tableGateway);
                    return $dao;
                },
                'TipoObraTableGateway' => function ($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new TipoObra());
                    return new TableGateway('tipoobra',$dbAdapter,null,$resultSetPrototype);
                },

            ),
            
        );
        
    }    
    
}
