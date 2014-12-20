<?php
namespace Usuarios\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuarios\Form\Login;
use Usuarios\Form\LoginValidator;
use Usuarios\Model\Login as LoginService;

class LoginController extends AbstractActionController {

    private $login;

    public function setLogin(LoginService $login) {
        $this->login = $login;
    }

    public function indexAction() {
        $form = new Login("login");

        $loggedIn = $this->login->isLoggedIn();

        $viewParams = array('form' => $form, 'loggedIn' => $loggedIn);

        if ($loggedIn) {
            $viewParams['usuario'] = $this->login->getIdentity();
        }

        return $viewParams;
    }

    public function autenticarAction() {

        if (!$this->request->isPost()) {
            $this->redirect()->toRoute('usuarios', array('controller' => 'login'));
        }

        $form = new Login("login");

        $form->setInputFilter(new LoginValidator());

        // Obtenemos los datos desde el Formulario con POST data:
        $data = $this->request->getPost();


        $form->setData($data);

        // Validando el form
        if (!$form->isValid()) {

            $modelView = new ViewModel(array('form' => $form));
            $modelView->setTemplate('usuarios/login/index');
            return $modelView;
        }

        $values = $form->getData();

        $nombre = $values['nombre'];
        $clave = $values['password'];

        try {
            $this->login->setMessage('El nombre de Usuario y Password no coinciden.', LoginService::NOT_IDENTITY);
            $this->login->setMessage('La contraseña ingresada es incorrecta. Inténtelo de nuevo.', LoginService::INVALID_CREDENTIAL);
            $this->login->setMessage('Los campos de Usuario y Password no pueden dejarse en blanco.', LoginService::INVALID_LOGIN);
            $this->login->login($nombre, $clave);

            $this->layout()->mensaje = "Login Correcto!!!";
            $this->layout()->colorMensaje = "green";
            
            return $this->forward()->dispatch('Usuarios\Controller\Login', array('action' => 'success'));
        } catch (\Exception $e) {
            $this->layout()->mensaje = $e->getMessage();
            return $this->forward()->dispatch('Usuarios\Controller\Login', array('action' => 'index'));
        }
    }

    public function successAction() {
        return array('titulo' => 'Página de exito');
    }

    public function logoutAction() {
        $this->login->logout();
        $this->layout()->mensaje = 'Ha cerrado sesión con éxito!';
        return $this->forward()->dispatch('Usuarios\Controller\Login', array('action' => 'index'));
    }

}
