<?php

namespace Artistas\Form;

use Zend\Form\Form;
use Zend\Form\Factory;

class Artista extends Form{
    
    public function __construct($name = null) {
        parent::__construct($name);
        
        $this->setAttribute('method','post');
        
        $this->add(array (
            'name' => 'idArtista',
            'attributes' => array(
                'type' => 'hidden',
            ),
            
        ));
        $this->add(array (
            'type' => 'Zend\Form\Element\Text',
            'name' => 'nombre',
            'options' => array (
                'label' => 'Nombre',
            ),
        ));     
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'fechaNacimiento',
            'options' => array (
                'label' => 'Fecha de nacimiento aaaa-mm-dd'
            ),
            'attributes' => array(
                'min' => '1900-01-01',
                'max' => '2050-01-01',
                'step' => '1',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'fechaMuerte',
            'options' => array (
                'label' => 'Fecha de fallecimiento aaaa-mm-dd',
            ),
            'attributes' => array(
                'min' => '1900-01-01',
                'max' => '2050-01-01',
                'step' => '1',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'direccion',
            'options' => array (
                'label' => 'Dirección',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'lugar',
            'options' => array (
                'label' => 'Lugar',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'telefono',
            'options' => array (
                'label' => 'Teléfono',
            ),
        ));
        
        $factory = new Factory();
        
        $email = $factory->createElement(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'options' => array (
                'label' => 'Correo electrónico',
            ),
            'attributes' => array(
                'size' => 50
            ),
        ));
        $this->add($email);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'facebook',
            'options' => array (
                'label' => 'Facebook',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'twitter',
            'options' => array (
                'label' => 'Twitter',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'semblanza',
            'options' => array (
                'label' => 'Semblanza',
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


