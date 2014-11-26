<?php


namespace Prestamos\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Prestamos\Model\Entity\Prestamo;


class IndexController extends AbstractActionController {
    
    private $prestamoDao;
    private $obraDao;
    private $entidadDao;
    
    public function getObraDao(){
        if(!$this->obraDao){
            $sm = $this->getServiceLocator();
            $this->obraDao = $sm->get('Obras\Model\Dao\ObraDao');
        }
        return $this->obraDao;
    }
    public function getPrestamoDao(){
        if(!$this->prestamoDao){
            $sm = $this->getServiceLocator();
            $this->prestamoDao = $sm->get('Prestamos\Model\Dao\PrestamoDao');
        }
        return $this->prestamoDao;
    }
    public function getEntidadDao(){
        if(!$this->entidadDao){
            $sm = $this->getServiceLocator();
            $this->entidadDao = $sm->get('Entidades\Model\Dao\EntidadDao');
        }
        return $this->entidadDao;
    }
    
    public function indexAction() {
        return new ViewModel(array(
            'title' => 'Listado de los préstamos',
            'prestamos' => $this->getPrestamoDao()->obtenerTodos(),
        ));
       
    }

    public function crearAction(){
        $form = $this->getForm();
        $form->get('fechaRegreso')->setAttribute('disabled', 'disabled');
        //$form = new \Obras\Form\Obra("obra");
        return array('title' => 'Dar de alta un Préstamo','form' => $form);
        
    }
//    aca hay que poner que no se pueda editar
    //si ya se devolvio el prestamo 
    public function editarAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id){
            return $this->redirect()->toRoute('prestamos');
        }
        
        //$form = new \Obras\Form\Obra("obra");
        $form = $this->getForm();
        $form->get('fechaRegreso')->setAttribute('disabled','disabled');
        $prestamo = $this->getPrestamoDao()->obtenerPorId($id);
        $form->bind($prestamo);
        $form->get('send')->setAttribute('value', 'Editar');
        
        $modelView = new ViewModel(array('title' => 'Modificar datos del préstamo', 'form' => $form));
        $modelView->setTemplate('prestamos/index/crear');
        return $modelView;
    }
//
    public function guardarAction(){
        if(!$this->request->isPost()){
            return $this->redirect()->toRoute('prestamos',array('controller' => 'index'));
        }
        $form = $this->getForm();
        //$form = new \Obras\Form\Obra("obra");
        $form->setInputFilter(new \Prestamos\Form\PrestamoValidator());
        $data = $this->request->getPost();
        $form->setData($data);
        
        if(!$form->isValid()){
            $modelView = new ViewModel(array('title' => 'Validando Préstamo','form'=>$form));
            $modelView->setTemplate('prestamos/index/crear');
            return $modelView;
        }
        
        $dataForm = $form->getData();
        
        $dataForm['idObra'] = $dataForm['obra'];
        $dataForm['idEntidad'] = $dataForm['entidad'];
        
        $prestamo = new \Prestamos\Model\Entity\Prestamo();
        $prestamo->exchangeArray($dataForm);
        
        $this->getPrestamoDao()->guardar($prestamo);
        
        $obra = $this->getObraDao()->obtenerPorId($dataForm['idObra']);
        $this->getObraDao()->guardarPrestada($obra,$prestamo->getFechaPrestamo());
        
        return $this->redirect()->toRoute('prestamos',array(
            'controller' => 'index',
            'action' => 'index',
        ));
    }
    
    private function getForm(){
        $form = new \Prestamos\Form\Prestamo("prestamo");
        $form->get('obra')->setValueOptions($this->getObraDao()->obtenerObrasSelectFiltrado());
//        $form->get('obra')->setValueOptions($this->getObraDao()->obtenerObrasSelect());
        $form->get('entidad')->setValueOptions($this->getEntidadDao()->obtenerEntidadesSelect() );
        
        return $form;
    }
//
    public function regresarObraAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!id){
            return $this->redirect()->toRoute('prestamos');
        }
        $prestamo = new Prestamo();
        $prestamo->setIdPrestamo($id);
        $this->redirect()->toRoute('prestamos');        
    }    

    
}
