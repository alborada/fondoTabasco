<?php
namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuarios\Form\Login;
use Usuarios\Form\LoginValidator;

use Usuarios\Model\Dao\IUsuarioDao;

class LoginController extends AbstractActionController{
    private $usuarioDao;
    
    public function setUsuarioDao(IUsuarioDao $usuarioDao){
        $this->usuarioDao = $usuarioDao;
    }
    
    public function indexAction(){
        $form = new Login("login");
        return array('form' => $form);
    }
    
    public function autenticarAction(){
        if (!$this->request->isPost()){
            $this->redirect()->toRoute('usuarios', array('controller' => 'login'));
        }
        $form = new Login("login");
        $form->setInputFilter(new LoginValidator());
        
        $data = $this->request->getPost();
        $form->setData($data);
        //Validando el form aqui
        if(!$form->isValid()){
            $modelView = new ViewModel(array('form' => $form));
            $modelView->setTemplate('usuarios/login/index');
            return $modelView;
        }
        $values = $form->getData();
        $email = $values['email'];
        $clave = $values['clave'];
        $cuentaUsuario = $this->usuarioDao->obtenerCuenta($email, $clave);
        
        if ($cuentaUsuario !== null){
            $this->layout()->mensaje = "Login correcto!!!";
            $this->layout()->colorMensaje = "green";
            
            return $this->forward()->dispatch('Usuarios\Controller\Login',
                    array('action' => 'success'));
        }else{
            $this->layout()->mensaje= "Login incorrecto";
            return $this->forward()->dispatch('Usuarios\Controller\Login',
                    array('action' => 'index'));
        }
    }
    
    public function successAction(){
        return array('titulo' => 'Página de éxito en Login');
    }
    
}


