<?php

namespace Artistas\Form;
use Zend\Validator\StringLength;
use Zend\Validator\Identical;
use Zend\Validator\NotEmpty;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\I18n\Validator\Alnum;
use Zend\Validator\AbstractValidator;

class ArtistaValidator extends InputFilter{

    protected $opcionesAlnum = array(
        'allowWhiteSpace' => true,
        'messages' => array(
            'notAlnum' => "El valor no es alfanumérico !!!"
        )
    );
    
    public function __construct() {
        
        $translator = new \Zend\I18n\Translator\Translator();
        $translator->addTranslationFile('phparray', './module/Artistas/language/es.php');
        $translatorMvc = new \Zend\Mvc\I18n\Translator($translator);
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translatorMvc);

        
        $this->add(array(
            'name' => 'idArtista',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));

        $nombre = new Input('nombre');
        $nombre->setRequired(true);
        $nombre->getFilterChain()
                ->attachByName('StripTags')
                ->attachByName('StringTrim');
        $nombre->getValidatorChain()
                ->addValidator(new Alnum($this->opcionesAlnum));
        
        $this->add($nombre);
//        $this->add(array(
//            'name' => 'nombre',
//            'required' => true,
//            'filters' => array(
//                array('name' => 'StripTags'),
//                array('name' => 'StringTrim'),
//            ),
//            'validators' => array(
//                array(
//                    'name' => 'Alnum',
//                    'options' => array(
//                        'allowWhiteSpace' => true,
//                    )
//                ),
//            ),
//        ));
        
        $this->add(array(
            'name' => 'fechaNacimiento',
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
            'name' => 'fechaMuerte',
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
        

        $this->add(array(
            'name' => 'direccion',
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
            'name' => 'lugar',
            'required' => false,
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
            'name' => 'telefono',
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
        //va el validador del email
        $this->add(array(
            'name' => 'email',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'facebook',
            'required' => false,
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
            'name' => 'twitter',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Alnum',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'semblanza',
            'required' => false,
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


