<?php
namespace Usuarios\Form;

use Zend\Validator\StringLength;
use Zend\InputFilter\InputFilter;

class LoginValidator extends InputFilter{
    
    public function __construct() {
        $this->add(
                array(
                    'name' => 'email',
                    'required' => 'true',
                    'validators' => array(
                        array(
                            'name' => 'EmailAddress',
                        ),
                    ),
                )
            );
            $this->add(
                    array(
                        'name' => 'clave',
                        'required' => 'true',
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'min' => 4,
                                    'max' => 8,
                                    'messages' => array(
                                    StringLength::TOO_SHORT => 'La passw debe tener min 4 caracteres',
                                    StringLength::TOO_LONG => 'La passw debe tener max 8 caracteres',
                                    )
                                ),
                            ),
                            array(
                                'name' => 'Alnum',
                            ),
                        ),
                    )
                );
    }
        
}
