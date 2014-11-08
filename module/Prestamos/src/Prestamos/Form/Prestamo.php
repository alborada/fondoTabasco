<?php

namespace Prestamos\Form;

use Zend\Form\Form;
use Zend\Form\Factory;

class Prestamo extends Form{
    
    public function __construct($name = null) {
        parent::__construct($name);
        
        $this->setAttribute('method','post');
        
        $this->add(array (
            'name' => 'idPrestamo',
            'attributes' => array(
                'type' => 'hidden',
            ),
            
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'fechaPrestamo',
            'options' => array (
                'label' => 'Fecha de prestamo aaaa-mm-dd'
            ),
            'attributes' => array(
                'min' => '1900-01-01',
                'max' => '2050-01-01',
                'step' => '1',
            ),
        ));
        
        $this->add(array (
            'type' => 'Zend\Form\Element\Text',
            'name' => 'ubicacion',
            'options' => array (
                'label' => 'Ubicacion',
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'obra',
            'options' => array(
                'label' => 'Obra',
                'empty_option' => 'Seleccione una obra =>',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'entidad',
            'options' => array(
                'label' => 'Entidad',
                'empty_option' => 'Seleccione una entidad =>',
            ),
        ));
                
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'fechaTentativaRegreso',
            'options' => array (
                'label' => 'Fecha tentativa de regreso aaaa-mm-dd'
            ),
            'attributes' => array(
                'min' => '1900-01-01',
                'max' => '2050-01-01',
                'step' => '1',
            ),
        ));

         $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'fechaRegreso',
            'options' => array (
                'label' => 'Fecha de Regreso aaaa-mm-dd'
            ),
            'attributes' => array(
                'min' => '1900-01-01',
                'max' => '2050-01-01',
                'step' => '1',
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


