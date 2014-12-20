<?php


namespace Usuarios;

use Usuarios\Model\Dao\UsuarioDao;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ControllerProviderInterface {

    public function init(ModuleManager $moduleManager) {
        $events = $moduleManager->getEventManager();
        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', array($this, 'initAuth'), 100);
    }
    
    public function initAuth(MvcEvent $e) {
        $application = $e->getApplication();
        $matches = $e->getRouteMatch();
        $controller = $matches->getParam('controller');
        $action = $matches->getParam('action');

        if (0 !== strpos($controller, __NAMESPACE__, 0)) {
            // Validamos cuando el controlador sea del modulo
            return;
        }
        
        if ($controller !== "Usuarios\Controller\Login" ||
                ($controller === "Usuarios\Controller\Login"
                && in_array($action, array('index', 'autenticar')))) {
            // Validamos cuando el controlador sea LoginController
            // exepto las acciones index y autenticar.
            return;
        }

        $sm = $application->getServiceManager();

        $auth = $sm->get('Usuarios\Model\Login');

        if (!$auth->isLoggedIn()) {
            // No existe Session, redirigimos al login.
            $controller = $e->getTarget();
            return $controller->redirect()->toRoute('usuarios', array('controller' => 'login'));
        }
    }
    
    public function getServiceConfig(){
        return array(
            'factories' => array(
                'Usuarios\Model\Login' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \Usuarios\Model\Login($dbAdapter);
                }
            ),
        );
    }
    
    public function getControllerConfig(){
        return array(
            'factories' => array(
                'Usuarios\Controller\Login' => function ($sm) {
                    $controller = new \Usuarios\Controller\LoginController();
                    $locator = $sm->getServiceLocator();
                    $controller->setLogin($locator->get('Usuarios\Model\Login'));
                    return $controller;
                },
            )
        );
//        return array(
//            'factories' => array (
//                'Usuarios\Controller\Login' => function ($sm){
//                    $controller = new \Usuarios\Controller\LoginController();
//                    $locator = $sm->getServiceLocator();
//                    $controller->setUsuarioDao($locator->get('UsuarioDao'));
//                    return $controller;
//                }
//            )
//        );
    }

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
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
}
