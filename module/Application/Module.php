<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Config\Reader\Ini;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $this->initConfig($e);
        $this->initViewRender($e);
        //$this->initEnvironment($e);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    protected function initConfig($e){
        $application = $e->getApplication();
        $services = $application->getServiceManager();
        
        $services->setFactory('ConfigIni', function ($services) {
            $reader = new Ini();
            $data = $reader->fromFile(__DIR__.'/config/config.ini');
            return $data;
        });
    }

    protected function initViewRender($e){
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $viewRender = $sm->get('ViewManager')->getRenderer();
        $config = $sm->get('ConfigIni');
        
        $viewRender->headTitle($config['parametros']['titulo']);
        $viewRender->headMeta()
                   ->setCharset($config['parametros']['view']['charset']);
        $viewRender->doctype($config['parametros']['view']['doctype']);
    }

    protected function initEnvironment($e){
        error_reporting(E_ALL | E_STRICT);
        init_set("display_errors",true);
        
        $application = $e->getApplication();
        $config = $application->getServiceManager()->get('ConfigIni');
        
        $timeZone = (string)$config['parametros']['timezone'];
        if(empty($timeZone)){
            $timeZone = "America/Mexico_City";
        }
        date_default_timezone_get($timeZone);
    }

        public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
