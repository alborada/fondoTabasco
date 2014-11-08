<?php


namespace Prestamos;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Obras\Model\Entity\Obra;
use Obras\Model\Dao\ObraDao;
use Entidades\Model\Entity\Entidad;
use Entidades\Model\Dao\EntidadDao;
use Prestamos\Model\Entity\Prestamo;
use Prestamos\Model\Dao\PrestamoDao;

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
                'Prestamos\Model\Dao\PrestamoDao' => function($sm){
                    $tableGateway = $sm->get('PrestamoTableGateway');
                    $dao = new PrestamoDao($tableGateway);
                    return $dao;
                },
                'PrestamoTableGateway' => function ($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Prestamo());
                    return new TableGateway('prestamo',$dbAdapter,null,$resultSetPrototype);
                },
                'Entidades\Model\Dao\EntidadDao' => function($sm){
                    $tableGateway = $sm->get('EntidadTableGateway');
                    $dao = new EntidadDao($tableGateway);
                    return $dao;
                },
                'EntidadTableGateway' => function ($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Entidad());
                    return new TableGateway('entidad',$dbAdapter,null,$resultSetPrototype);
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
            ),
            
        );
        
    }       
}
