<?php

namespace Artistas\Model\Entity;


class Artista {
    
    private $idArtista;
    private $nombre;
    private $fechaNacimiento;
    private $fechaMuerte;
    private $direccion;
    private $telefono;
    private $semblanza;
    private $email;
    private $facebook;
    private $twitter;
    private $lugar;
    
    function getIdArtista() {
        return $this->idArtista;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    function getFechaMuerte() {
        return $this->fechaMuerte;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getSemblanza() {
        return $this->semblanza;
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

    function getLugar() {
        return $this->lugar;
    }

    function setIdArtista($idArtista) {
        $this->idArtista = $idArtista;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    function setFechaMuerte($fechaMuerte) {
        $this->fechaMuerte = $fechaMuerte;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setSemblanza($semblanza) {
        $this->semblanza = $semblanza;
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

    function setLugar($lugar) {
        $this->lugar = $lugar;
    }

    public function exchangeArray($data){
            $this->idArtista=(isset($data['idArtista']))? $data['idArtista']:null;
            $this->nombre=(isset($data['nombre']))? $data['nombre']:null;
            $this->fechaNacimiento=(isset($data['fechaNacimiento']))? $data['fechaNacimiento']:null;
            $this->fechaMuerte=(isset($data['fechaMuerte']))? $data['fechaMuerte']:null;
            $this->direccion=(isset($data['direccion']))? $data['direccion']:null;
            $this->telefono=(isset($data['telefono']))? $data['telefono']:null;
            $this->semblanza=(isset($data['semblanza']))? $data['semblanza']:null;
            $this->email=(isset($data['email']))? $data['email']:null;
            $this->facebook=(isset($data['facebook']))? $data['facebook']:null;
            $this->twitter=(isset($data['twitter']))? $data['twitter']:null;
            $this->lugar=(isset($data['lugar']))? $data['lugar']:null;
    }
    
    public function getArrayCopy(){
        return get_object_vars($this);
    }
            
}
