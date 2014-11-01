<?php


namespace Obras\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Obras\Model\Entity\Estilo;

class IndexController extends AbstractActionController {
    
    private $estiloDao;
    
    public function getEstiloDao(){
        if(!$this->estiloDao){
            $sm = $this->getServiceLocator();
            $this->estiloDao = $sm->get('Obras\Model\Dao\EstiloDao');
        }
        return $this->estiloDao;
    }
    
    public function indexAction() {
        return new ViewModel(array(
            'title' => 'Listado de los estilos',
            'estilo' => $this->getEstiloDao()->obtenerTodos(),
        ));
       
    }

    public function crearAction(){
        $form = new \Obras\Form\Estilo("estilo");
        return array('title' => 'Dar de alta Estilo','form' => $form);
        
    }
//    
    public function editarAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id){
            return $this->redirect()->toRoute('obras');
        }
        $form = new \Obras\Form\Estilo("estilo");
        $estilo = $this->getEstiloDao()->obtenerPorId($id);
        $form->bind($estilo);
        $form->get('send')->setAttribute('value', 'Editar');
        
        $modelView = new ViewModel(array('title' => 'Modificar datos del estilo', 'form' => $form));
        $modelView->setTemplate('obras/index/crear');
        return $modelView;
    }
//
    public function guardarAction(){
        if(!$this->request->isPost()){
            return $this->redirect()->toRoute('obras',array('controller' => 'index'));
        }
        $form = new \Obras\Form\Estilo("estilo");
        $form->setInputFilter(new \Obras\Form\EstiloValidator());
        $data = $this->request->getPost();
        $form->setData($data);
        
        if(!$form->isValid()){
            $modelView = new ViewModel(array('title' => 'Validando Estilo','form'=>$form));
            $modelView->setTemplate('obras/index/crear');
            return $modelView;
        }
        
        $estilo = new \Obras\Model\Entity\Estilo();
        $estilo->exchangeArray($form->getData());
        
        $this->getEstiloDao()->guardar($estilo);
        return $this->redirect()->toRoute('obras');
    }
//
    public function eliminarAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!id){
            return $this->redirect()->toRoute('obras');
        }
        $estilo = new Estilo();
        $estilo->setIdEstilo($id);
        $this->redirect()->toRoute('obras');        
    }


    public function fooAction() {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /module-specific-root/skeleton/foo
        return array();
    }
    

    
    
}
