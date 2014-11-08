<?php

namespace Prestamos\Model\Entity;
use Obras\Model\Entity\Obra;
use Entidades\Model\Entity\Entidad;


class Prestamo {
    
    private $idPrestamo;
    private $fechaPrestamo;
    private $ubicacion;
    private $fechaTentativaRegreso;
    private $fechaRegreso;
    
    private $obra;
    private $entidad;
    
    public function getIdPrestamo() {
        return $this->idPrestamo;
    }

    public function getFechaPrestamo() {
        return $this->fechaPrestamo;
    }

    public function getUbicacion() {
        return $this->ubicacion;
    }

    public function getFechaTentativaRegreso() {
        return $this->fechaTentativaRegreso;
    }
    
    public function getFechaRegreso(){
        return $this->fechaRegreso;
    }

    public function getObra() {
        return $this->obra;
    }

    public function getEntidad() {
        return $this->entidad;
    }

    public function setIdPrestamo($idPrestamo) {
        $this->idPrestamo = $idPrestamo;
    }

    public function setFechaPrestamo($fechaPrestamo) {
        $this->fechaPrestamo = $fechaPrestamo;
    }

    public function setUbicacion($ubicacion) {
        $this->ubicacion = $ubicacion;
    }

    public function setFechaTentativaRegreso($fechaTentativaRegreso) {
        $this->fechaTentativaRegreso = $fechaTentativaRegreso;
    }
    
    public function setFechaRegreso($fechaRegreso){
        $this->fechaRegreso = $fechaRegreso;
    }

    public function setObra(Obra $obra) {
        $this->obra = $obra;
    }

    public function setEntidad(Entidad $entidad) {
        $this->entidad = $entidad;
    }

    public function exchangeArray($data){
            $this->idPrestamo=(isset($data['idPrestamo']))? $data['idPrestamo']:null;
            $this->fechaPrestamo=(isset($data['fechaPrestamo']))? $data['fechaPrestamo']:null;
            $this->ubicacion=(isset($data['ubicacion']))? $data['ubicacion']:null;
            $this->fechaTentativaRegreso=(isset($data['fechaTentativaRegreso']))? $data['fechaTentativaRegreso']:null;
            $this->fechaRegreso=(isset($data['fechaRegreso']))? $data['fechaRegreso']:null;
            
            $this->obra=new Obra();
            $this->obra->setIdObra((isset($data['idObra']))? $data['idObra']:null);
            $this->obra->setTitulo((isset($data['tituloObra']))? $data['tituloObra']:null);
//            $this->obra->setAnio((isset($data['anio']))? $data['anio']:null);
//            $this->obra->setTecnica((isset($data['tecnica']))? $data['tecnica']:null);
//            $this->obra->setMedidas((isset($data['medidas']))? $data['medidas']:null);
//            $this->obra->setDescripcion((isset($data['descripcion']))? $data['descripcion']:null);
//            $this->obra->setArtista((isset($data['idArtista']))? $data['idArtista']:null);
//            $this->obra->setTipoObra((isset($data['idTipoObra']))? $data['idTipoObra']:null);
//            $this->obra->setEstilo((isset($data['idEstilo']))? $data['idEstilo']:null);
            
            $this->entidad =new Entidad();
            $this->entidad->setIdEntidad((isset($data['idEntidad']))? $data['idEntidad']:null);
            $this->entidad->setNombre((isset($data['nombreEntidad']))? $data['nombreEntidad']:null);
//            $this->entidad->setDireccion((isset($data['direccion']))? $data['direccion']:null);
//            $this->entidad->setLugar((isset($data['lugar']))? $data['lugar']:null);
//            $this->entidad->setTelefono((isset($data['telefono']))? $data['telefono']:null);
//            $this->entidad->setEmail((isset($data['email']))? $data['email']:null);
//            $this->entidad->setFacebook((isset($data['facebook']))? $data['facebook']:null);
//            $this->entidad->setTwitter((isset($data['twitter']))? $data['twitter']:null);
            
    }
    
    
    public function getArrayCopy(){
        return get_object_vars($this);
    }
    
}





