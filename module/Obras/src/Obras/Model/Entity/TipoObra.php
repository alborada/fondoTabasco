<?php

namespace Obras\Model\Entity;

class TipoObra {
    
    
    private $idtipoObra;
    private $descripcion;    
    
    public function getIdtipoObra() {
        return $this->idtipoObra;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setIdtipoObra($idtipoObra) {
        $this->idtipoObra = $idtipoObra;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    public function exchangeArray($data){
            $this->idtipoObra=(isset($data['idtipoObra']))? $data['idtipoObra']:null;
            $this->descripcion=(isset($data['descripcion']))? $data['descripcion']:null;
    }
    
    public function getArrayCopy(){
        return get_object_vars($this);
    }    

}
