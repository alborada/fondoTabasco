<?php


namespace Entidades\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Entidades\Model\Entity\Entidad;

class IndexController extends AbstractActionController {
    
    private $entidadDao;
    
    public function getEntidadDao(){
        if(!$this->entidadDao){
            $sm = $this->getServiceLocator();
            $this->entidadDao = $sm->get('Entidades\Model\Dao\EntidadDao');
        }
        return $this->entidadDao;
    }
    
    public function indexAction() {
        return new ViewModel(array(
            'title' => 'Listado de las entidades (a recibir los préstamos)',
            'entidad' => $this->getEntidadDao()->obtenerTodos(),
        ));
       
    }

    public function crearAction(){
        $form = new \Entidades\Form\Entidad("entidad");
        return array('title' => 'Dar de alta Entidad','form' => $form);
        
    }
//    
    public function editarAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id){
            return $this->redirect()->toRoute('entidades');
        }
        $form = new \Entidades\Form\Entidad("entidad");
        $entidad = $this->getEntidadDao()->obtenerPorId($id);
        $form->bind($entidad);
        $form->get('send')->setAttribute('value', 'Editar');
        
        $modelView = new ViewModel(array('title' => 'Modificar datos de la entidad', 'form' => $form));
        $modelView->setTemplate('entidades/index/crear');
        return $modelView;
    }
//
    public function guardarAction(){
        if(!$this->request->isPost()){
            return $this->redirect()->toRoute('entidades',array('controller' => 'index'));
        }
        $form = new \Entidades\Form\Entidad("entidad");
        $form->setInputFilter(new \Entidades\Form\EntidadValidator());
        $data = $this->request->getPost();
        $form->setData($data);
        
        if(!$form->isValid()){
            $modelView = new ViewModel(array('title' => 'Validando Entidad','form'=>$form));
            $modelView->setTemplate('entidades/index/crear');
            return $modelView;
        }
        
        $entidad = new \Entidades\Model\Entity\Entidad();
        $entidad->exchangeArray($form->getData());
        
        $this->getEntidadDao()->guardar($entidad);
        return $this->redirect()->toRoute('entidades');
    }
//
    public function eliminarAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!id){
            return $this->redirect()->toRoute('entidades');
        }
        $entidad = new Entidad();
        $entidad->setIdEntidad($id);
        $this->redirect()->toRoute('entidades');        
    }


    public function fooAction() {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /module-specific-root/skeleton/foo
        return array();
    }

    
}
