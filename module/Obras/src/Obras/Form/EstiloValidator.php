<?php

namespace Obras\Form;
use Zend\InputFilter\InputFilter;

class EstiloValidator extends InputFilter{

    public function __construct() {
        
        $this->add(array(
            'name' => 'idEstilo',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));

        $this->add(array(
            'name' => 'descripcion',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => array(
                        'allowWhiteSpace' => true,
                    )
                ),
            ),
        ));
        
    }
    
}


