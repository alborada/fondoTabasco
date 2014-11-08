<?php

namespace Prestamos\Form;
use Zend\InputFilter\InputFilter;

class PrestamoValidator extends InputFilter {
    
        public function __construct() {
        
        $this->add(array(
            'name' => 'idPrestamo',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));

        $this->add(array(
            'name' => 'fechaPrestamo',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Date',
                    'options' => array(
                        'format' => 'Y-m-d',
                    )
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'ubicacion',
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
        

        $this->add(array(
            'name' => 'fechaTentativaRegreso',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Date',
                    'options' => array(
                        'format' => 'Y-m-d',
                    )
                ),
            ),
        ));        

        $this->add(array(
            'name' => 'fechaRegreso',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'Date',
                    'options' => array(
                        'format' => 'Y-m-d',
                    )
                ),
            ),
        ));        
        
    }
    
    
}
