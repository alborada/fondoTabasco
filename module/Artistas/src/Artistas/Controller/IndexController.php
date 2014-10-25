<?php

namespace Artistas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Catalogo\Model\Entity\Artista;

class IndexController extends AbstractActionController {

    private $artistaDao;
    
    public function getArtistaDao(){
        if(!$this->artistaDao){
            $sm = $this->getServiceLocator();
            $this->artistaDao = $sm->get('Artistas\Model\Dao\ArtistaDao');
        }
        return $this->artistaDao;
    }
    
    public function indexAction() {
        return new ViewModel(array(
            'title' => 'Listado de los artistas',
            'artistas' => $this->getArtistaDao()->obtenerTodos(),
        ));
       
    }

//    public function crearAction(){
//        
//    }
//    
//    public function editarAction(){
//        
//    }
//
//    public function guardarAction(){
//        
//    }
//
//    public function eliminarAction(){
//        
//    }


    public function fooAction() {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /module-specific-root/skeleton/foo
        return array();
    }
}
