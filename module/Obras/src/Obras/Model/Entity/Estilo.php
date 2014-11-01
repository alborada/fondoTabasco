<?php

namespace Obras\Model\Entity;


class Estilo {
    
    private $idEstilo;
    private $descripcion;
    
    function getIdEstilo() {
        return $this->idEstilo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setIdEstilo($idEstilo) {
        $this->idEstilo = $idEstilo;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function exchangeArray($data){
            $this->idEstilo=(isset($data['idEstilo']))? $data['idEstilo']:null;
            $this->descripcion=(isset($data['descripcion']))? $data['descripcion']:null;
    }
    
    public function getArrayCopy(){
        return get_object_vars($this);
    }
    
    
}
