<?php

namespace Obras\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Obras\Model\Entity\Obra;

class ObrasController extends AbstractActionController{
    
    private $obraDao;
    private $estiloDao;
    private $tipoObraDao;
    private $artistaDao;
    
    public function getObraDao(){
        if(!$this->obraDao){
            $sm = $this->getServiceLocator();
            $this->obraDao = $sm->get('Obras\Model\Dao\ObraDao');
        }
        return $this->obraDao;
    }
    public function getEstiloDao(){
        if(!$this->estiloDao){
            $sm = $this->getServiceLocator();
            $this->estiloDao = $sm->get('Obras\Model\Dao\EstiloDao');
        }
        return $this->estiloDao;
    }
    public function getTipoObraDao(){
        if(!$this->tipoObraDao){
            $sm = $this->getServiceLocator();
            $this->tipoObraDao = $sm->get('Obras\Model\Dao\TipoObraDao');
        }
        return $this->tipoObraDao;
    }
    public function getArtistaDao(){
        if(!$this->artistaDao){
            $sm = $this->getServiceLocator();
            $this->artistaDao = $sm->get('Artistas\Model\Dao\ArtistaDao');
        }
        return $this->artistaDao;
    }
    
    public function indexAction() {
        return new ViewModel(array(
            'title' => 'Listado de las obras',
            'obras' => $this->getObraDao()->obtenerTodos(),
        ));
       
    }

    public function crearAction(){
        $form = $this->getForm();
        //$form = new \Obras\Form\Obra("obra");
        return array('title' => 'Dar de alta Obra','form' => $form);
        
    }
//    
    public function editarAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id){
            return $this->redirect()->toRoute('obras');
        }
        
        //$form = new \Obras\Form\Obra("obra");
        $form = $this->getForm();
        $obra = $this->getObraDao()->obtenerPorId($id);
        $form->bind($obra);
        $form->get('send')->setAttribute('value', 'Editar');
        
        $modelView = new ViewModel(array('title' => 'Modificar datos de la obra', 'form' => $form));
        $modelView->setTemplate('obras/obras/crear');
        return $modelView;
    }
//
    public function guardarAction(){
        if(!$this->request->isPost()){
            return $this->redirect()->toRoute('obras',array('controller' => 'obras'));
        }
        $form = $this->getForm();
        //$form = new \Obras\Form\Obra("obra");
        $form->setInputFilter(new \Obras\Form\ObraValidator());
        $data = $this->request->getPost();
        $form->setData($data);
        
        if(!$form->isValid()){
            $modelView = new ViewModel(array('title' => 'Validando Obra','form'=>$form));
            $modelView->setTemplate('obras/obras/crear');
            return $modelView;
        }
        
        $dataForm = $form->getData();
        
        $dataForm['idEstilo'] = $dataForm['estilo'];
        $dataForm['idTipoObra'] = $dataForm['tipoObra'];
        $dataForm['idArtista'] = $dataForm['artista'];
        
        $obra = new \Obras\Model\Entity\Obra();
        $obra->exchangeArray($dataForm);
        
        $this->getObraDao()->guardar($obra);
        return $this->redirect()->toRoute('obras',array(
            'controller' => 'obras',
            'action' => 'index',
        ));
    }
    
    private function getForm(){
        $form = new \Obras\Form\Obra("obra");
        
        $form->get('estilo')->setValueOptions($this->getEstiloDao()->obtenerEstilosSelect());
        $form->get('tipoObra')->setValueOptions($this->gettipoObraDao()->obtenerTiposObraSelect() );
        $form->get('artista')->setValueOptions($this->getArtistaDao()->obtenerArtistasSelect() );
        
        return $form;
    }
//
    public function eliminarAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!id){
            return $this->redirect()->toRoute('obras');
        }
        $obra = new Obra();
        $obra->setIdObra($id);
        $this->redirect()->toRoute('obras');        
    }    
    
    
}
