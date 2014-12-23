<?php


namespace Usuarios;

use Usuarios\Model\Dao\UsuarioDao;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ControllerProviderInterface {

    public function init(ModuleManager $moduleManager) {
        $events = $moduleManager->getEventManager();
        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach(array (__NAMESPACE__, 'Artistas','Entidades','Obras','Prestamos','Usuarios'),
                'dispatch', array($this, 'initAuth'), 100);
    }
    
    public function initAuth(MvcEvent $e) {
        //die("funciona Ok!");
        $application = $e->getApplication();
        $matches = $e->getRouteMatch();
        $controller = $matches->getParam('controller');
        $action = $matches->getParam('action');

//        if (0 !== strpos($controller, __NAMESPACE__, 0)) {
//            // Validamos cuando el controlador sea del modulo
//            return;
//        }
        
//        if ($controller !== "Usuarios\Controller\Login" ||
//                ($controller === "Usuarios\Controller\Login"
//                && in_array($action, array('index', 'autenticar')))) {
//            // Validamos cuando el controlador sea LoginController
//            // exepto las acciones index y autenticar.
//            return;
//        }
        if (($controller === "Usuarios\Controller\Error"
                && in_array($action, array('index', 'denied')))) {
            // Validamos cuando el controlador sea LoginController
            // exepto las acciones index y autenticar.
            return;
        }
        
        if (($controller === "Artistas\Controller\Index"
                && in_array($action, array('index')))) {
            // Validamos cuando el controlador sea LoginController
            // exepto las acciones index y autenticar.
            return;
        }
        
        if (($controller === "Usuarios\Controller\Login"
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
    
    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $app = $e->getParam('application');
        $app->getEventManager()->attach('dispatch',array($this,'initAcl'),100);
    }
   
    public function initAcl(MvcEvent $e){
        $acl = new Acl();
        $acl->addRole(new Role('invitado'))
                ->addRole(new Role('m'),'invitado')
                ->addRole(new Role('a'), 'invitado');
        
        $acl->addResource(new Resource('application:index'))
                ->addResource(new Resource('artistas:index'))
                ->addResource(new Resource('entidades:index'))
                ->addResource(new Resource('obras:index'))
                ->addResource(new Resource('obras:obras'))
                ->addResource(new Resource('obras:tipo-obra'))
                ->addResource(new Resource('prestamos:index'))
                ->addResource(new Resource('usuarios:index'))
                ->addResource(new Resource('usuarios:login'))
                ->allow('invitado', 'application:index', array('index'))
                ->allow('invitado', 'usuarios:login', array('index', 'autenticar'))
                ->allow('invitado', 'artistas:index', array('index'))
                ->allow('m','entidades:index')
                ->allow('m','obras:obras')
                ->allow('m','usuarios:login',array('logout'))
                ->allow('a');

        $application = $e->getApplication();
        $services = $application->getServiceManager();
        $services->setService('AclService', $acl);

        $matches = $e->getRouteMatch();

        $controllerClass = $matches->getParam('controller');
        $controllerArray = explode("\\", $controllerClass);

        $module = strtolower($controllerArray[0]);
        $controller = strtolower($controllerArray[2]);
        
        if($controllerArray[2] === "TipoObra"){
            //die('aqui:' . $controllerArray[2]);
            $controller = "tipo-obra";
        }

        $action = $matches->getParam('action');

        $resourceName = $module . ':' . $controller;
        
        if (!$acl->isAllowed($this->getRole($services), $resourceName, $action)) {
            // si el usuario no tiene permiso y esta intentando acceder a 
            // una página de la aplicación sin privilegios, entonces lo redirigimos
            // al controlador de error y accion denied.
            $matches->setParam('controller', 'Usuarios\Controller\Error');
            $matches->setParam('action', 'denied');
        }
        
    }
    
    private function getRole($sm) {

        $auth = $sm->get('Usuarios\Model\Login');

        $role = "invitado";

        if ($auth->isLoggedIn()) {
            if (!empty($auth->getIdentity()->tipo)) {
                $role = $auth->getIdentity()->tipo;
            } else {
                $auth->getIdentity()->tipo = "m";
                $role = $auth->getIdentity()->tipo;
            }
        }
        return $role;
    }
    
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }


    
}
