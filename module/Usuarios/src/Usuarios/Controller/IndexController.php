<?php


namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController {
    
    public function indexAction() {
        //return array('titulo' => 'Hola Mundo desde usuarios');
        return $this->forward()->dispatch('Usuarios\Controller\Login', array('action' => 'index'));
    }


}
