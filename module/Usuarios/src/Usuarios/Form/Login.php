<?php
namespace Usuarios\Form;
use Zend\Form\Form;

class Login extends Form{
    //put your code here
    
    public function __construct($name = null) {
        parent::__construct($name);
        
//        $this->add(array(
//            'type' => 'Zend\Form\Element\Email',
//            'name' => 'email',
//            'options' => array(
//                'label' => 'Correo',
//            ),
//        ));
        $this->add(array (
            'type' => 'Zend\Form\Element\Text',
            'name' => 'nombre',
            'options' => array (
                'label' => 'Nombre de usuario',
            ),
        ));
        
        $this->add(array (
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'options' => array(
                'label' => 'Clave',
            ),
        ));
        $this->add(array (
            'name' => 'send',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Enviar',
            ),
        ));
    }
        
}
