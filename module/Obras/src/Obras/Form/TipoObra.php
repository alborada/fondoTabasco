<?php

namespace Obras\Form;

use Zend\Form\Form;
use Zend\Form\Factory;

class TipoObra extends Form{

    public function __construct($name = null) {
        parent::__construct($name);
        
        $this->setAttribute('method','post');
        
        $this->add(array (
            'name' => 'idtipoObra',
            'attributes' => array(
                'type' => 'hidden',
            ),
            
        ));
        $this->add(array (
            'type' => 'Zend\Form\Element\Text',
            'name' => 'descripcion',
            'options' => array (
                'label' => 'Descripción',
            ),
        ));
        $this->add(array (
            'name' => 'send',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Crear',
            ),
        ));
        
    }
       
}
