<?php

namespace Entidades\Model\Entity;


class Entidad {
    
    private $idEntidad;
    private $nombre;
    private $direccion;
    private $lugar;
    private $telefono;
    private $email;
    private $facebook;
    private $twitter;
    
    function getIdEntidad() {
        return $this->idEntidad;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getLugar() {
        return $this->lugar;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getEmail() {
        return $this->email;
    }

    function getFacebook() {
        return $this->facebook;
    }

    function getTwitter() {
        return $this->twitter;
    }

    function setIdEntidad($idEntidad) {
        $this->idEntidad = $idEntidad;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setLugar($lugar) {
        $this->lugar = $lugar;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setFacebook($fb) {
        $this->facebook = $fb;
    }

    function setTwitter($tw) {
        $this->twitter = $tw;
    }

    public function exchangeArray($data){
            $this->idEntidad=(isset($data['idEntidad']))? $data['idEntidad']:null;
            $this->nombre=(isset($data['nombre']))? $data['nombre']:null;
            $this->direccion=(isset($data['direccion']))? $data['direccion']:null;
            $this->lugar=(isset($data['lugar']))? $data['lugar']:null;
            $this->telefono=(isset($data['telefono']))? $data['telefono']:null;
            $this->email=(isset($data['email']))? $data['email']:null;
            $this->facebook=(isset($data['facebook']))? $data['facebook']:null;
            $this->twitter=(isset($data['twitter']))? $data['twitter']:null;
    }
    
    public function getArrayCopy(){
        return get_object_vars($this);
    }
            
}

