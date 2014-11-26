<?php


namespace Application;

use Zend\Config\Reader\Ini;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;



class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $this->initConfig($e);
        $this->initViewRender($e);
        $this->cambiar404($e);
        //$this->initEnvironment($e);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    protected function cambiar404($e){
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, function(MvcEvent $event) {
            $viewModel = $event->getViewModel();
            $viewModel->setTemplate('/layout/layout404.phtml');
        }, -200);
    }


    protected function initConfig($e) {
        $application = $e->getApplication();
        $services = $application->getServiceManager();

        $services->setFactory('ConfigIni', function ($services) {
            $reader = new Ini();
            $data = $reader->fromFile(__DIR__ . '/config/config.ini');
            return $data;
        });
    }
    
    protected function initViewRender($e) {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $viewRender = $sm->get('ViewManager')->getRenderer();
        $config = $sm->get('ConfigIni');

        $viewRender->headTitle($config['parametros']['titulo']);
        $viewRender->headMeta()
                ->setCharset($config['parametros']['view']['charset']);
        $viewRender->doctype($config['parametros']['view']['doctype']);
        
    }

    protected function initEnvironment($e) {
        error_reporting(E_ALL | E_STRICT);
        init_set("display_errors", true);

        $application = $e->getApplication();
        $config = $application->getServiceManager()->get('ConfigIni');

        $timeZone = (string) $config['parametros']['timezone'];
        if (empty($timeZone)) {
            $timeZone = "America/Mexico_City";
        }
        date_default_timezone_get($timeZone);
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }



}
