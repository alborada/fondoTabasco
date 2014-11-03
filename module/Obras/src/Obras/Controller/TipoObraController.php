<?php

namespace Obras\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Obras\Model\Entity\TipoObra;

class TipoObraController extends AbstractActionController{
    
    private $tipoObraDao;
    
    public function getTipoObraDao(){
        if(!$this->tipoObraDao){
            $sm = $this->getServiceLocator();
            $this->tipoObraDao = $sm->get('Obras\Model\Dao\TipoObraDao');
        }
        return $this->tipoObraDao;
    }
    
    public function indexAction() {
        return new ViewModel(array(
            'title' => 'Listado de los tipos de obra',
            'tipoObra' => $this->getTipoObraDao()->obtenerTodos(),
        ));
       
    }

    public function crearAction(){
        $form = new \Obras\Form\TipoObra("tipoObra");
        return array('title' => 'Dar de alta un tipo de obra','form' => $form);
        
    }
//    
    public function editarAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id){
            return $this->redirect()->toRoute('obras');
        }
        $form = new \Obras\Form\TipoObra("tipoObra");
        $tipoObra = $this->getTipoObraDao()->obtenerPorId($id);
        $form->bind($tipoObra);
        $form->get('send')->setAttribute('value', 'Editar');
        
        $modelView = new ViewModel(array('title' => 'Modificar datos del tipo de obra', 'form' => $form));
        $modelView->setTemplate('obras/tipo-obra/crear');
        return $modelView;
    }
//
    public function guardarAction(){
        if(!$this->request->isPost()){
            return $this->redirect()->toRoute('obras',array('controller' => 'tipo-obra'));
        }
        $form = new \Obras\Form\TipoObra("tipoObra");
        $form->setInputFilter(new \Obras\Form\TipoObraValidator());
        $data = $this->request->getPost();
        $form->setData($data);
        
        if(!$form->isValid()){
            $modelView = new ViewModel(array('title' => 'Validando Tipo de Obra','form'=>$form));
            $modelView->setTemplate('obras/tipo-obra/crear');
            return $modelView;
        }
        
        $tipoObra = new \Obras\Model\Entity\TipoObra();
        $tipoObra->exchangeArray($form->getData());
        
        $this->getTipoObraDao()->guardar($tipoObra);
        return $this->redirect()->toRoute('obras',array(
            'controller' => 'tipo-obra',
            'action' => 'index',
        ));
    }
//
    public function eliminarAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!id){
            return $this->redirect()->toRoute('obras');
        }
        $tipoObra = new TipoObra();
        $tipoObra->setIdtipoObra($id);
        $this->redirect()->toRoute('obras');        
    }

    
}
