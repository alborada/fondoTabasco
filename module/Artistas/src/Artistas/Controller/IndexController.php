<?php

namespace Artistas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Artistas\Model\Entity\Artista;

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
//        return new ViewModel(array(
//            'title' => 'Listado de los artistas',
//            'artistas' => $this->getArtistaDao()->obtenerTodos(),
//        ));
        $paginator = $this->getArtistaDao()->obtenerTodos();
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        $paginator->setItemCountPerPage(3);
        return new ViewModel(array(
                    'title' => 'Lista de Artistas',
                    'artistas' => $paginator->getIterator(),
                    'paginator' => $paginator,
                ));
    }

    public function verAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id){
            return $this->redirect()->toRoute('artistas');
        }
        return new ViewModel(array(
           'title' => 'Datos del artista solicitado',
            'artista' => $this->getArtistaDao()->obtenerPorId($id),
        ));
    }
    
    public function consultarAction(){
        //No lo usamos aun
        $titulo="";
        if(!$this->request->isPost()){
            return $this->redirect()->toRoute('artistas',array('controller' => 'index'));
        }
        $data = $this->request->getPost();
        $nombre = $data->nombre;
        if(!$nombre){
            $titulo="Se debe ingresar un nombre de artista para aplicar el filtro";
        }else{
            $titulo="Consulta de los artistas de nombre: " . $nombre;
        }
        //$email = $this->params()->fromRoute('email',null);
        return new ViewModel(array (
            'title' => $titulo,
            'artistas' => $this->getArtistaDao()->consultarArtistas($nombre),
        ));
    }
    
    public function crearAction(){
        $form = new \Artistas\Form\Artista("artista");
        
//        ZendX_JQuery::enableForm($form);
        
        return array('title' => 'Dar de alta Artista','form' => $form);
        
    }
//    
    public function editarAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id){
            return $this->redirect()->toRoute('artistas');
        }
        $form = new \Artistas\Form\Artista("artista");
        $artista = $this->getArtistaDao()->obtenerPorId($id);
        $form->bind($artista);
        $form->get('send')->setAttribute('value', 'Editar');
        
        $modelView = new ViewModel(array('title' => 'Modificar datos del artista', 'form' => $form));
        $modelView->setTemplate('artistas/index/crear');
        return $modelView;
    }
//
    public function guardarAction(){
        if(!$this->request->isPost()){
            return $this->redirect()->toRoute('artistas',array('controller' => 'index'));
        }
        $form = new \Artistas\Form\Artista("artista");
        $form->setInputFilter(new \Artistas\Form\ArtistaValidator());
        $data = $this->request->getPost();
        $form->setData($data);
        
        if(!$form->isValid()){
            $modelView = new ViewModel(array('title' => 'Validando Artista','form'=>$form));
            $modelView->setTemplate('artistas/index/crear');
            return $modelView;
        }
        
        $artista = new \Artistas\Model\Entity\Artista();
        $artista->exchangeArray($form->getData());
        
        $this->getArtistaDao()->guardar($artista);
        return $this->redirect()->toRoute('artistas');
    }
//
    public function eliminarAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!id){
            return $this->redirect()->toRoute('artistas');
        }
        $artista = new Artista();
        $artista->setIdArtista($id);
        $this->redirect()->toRoute('artistas');        
    }


    public function fooAction() {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /module-specific-root/skeleton/foo
        return array();
    }
}
