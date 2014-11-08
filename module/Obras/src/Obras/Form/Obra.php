<?php

namespace Obras\Form;

use Zend\Form\Form;
use Zend\Form\Factory;

class Obra extends Form{
    
    public function __construct($name = null) {
        parent::__construct($name);
        
        $this->setAttribute('method','post');
        $this->setAttribute('enctype','multipart/form-data');
        
        $this->add(array (
            'name' => 'idObra',
            'attributes' => array(
                'type' => 'hidden',
            ),
            
        ));
        $this->add(array (
            'type' => 'Zend\Form\Element\Text',
            'name' => 'titulo',
            'options' => array (
                'label' => 'Título',
            ),
        ));
        
        $this->add(array (
            'type' => 'Zend\Form\Element\Text',
            'name' => 'anio',
            'options' => array (
                'label' => 'Año',
            ),
        ));
        
        $this->add(array (
            'type' => 'Zend\Form\Element\Text',
            'name' => 'tecnica',
            'options' => array (
                'label' => 'Técnica',
            ),
        ));
        
        $this->add(array (
            'type' => 'Zend\Form\Element\Text',
            'name' => 'medidas',
            'options' => array (
                'label' => 'Medidas',
            ),
        ));

        

        $this->add(array (
            'type' => 'Zend\Form\Element\Text',
            'name' => 'descripcion',
            'attributes' => array(
                'size' => '100',
            ),
            'options' => array (
                'label' => 'Descripción',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'estilo',
            'options' => array(
                'label' => 'Estilo',
                'empty_option' => 'Seleccione un estilo =>',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'artista',
            'options' => array(
                'label' => 'Artista',
                'empty_option' => 'Seleccione un artista =>',
            ),
        ));
                
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'tipoObra',
            'options' => array(
                'label' => 'Tipo de Obra',
                'empty_option' => 'Seleccione un tipo de obra =>',
            ),
        ));
        
         $this->add(array(
            'name' => 'imagen',
            'attributes' => array(
                'type'  => 'file',
            ),
            'options' => array(
                'label' => 'Cargar imagen',
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


