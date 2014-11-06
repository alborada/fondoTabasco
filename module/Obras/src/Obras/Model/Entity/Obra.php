<?php

namespace Obras\Model\Entity;
use Artistas\Model\Entity\Artista;

class Obra {
    
    private $idObra;
    private $titulo;
    private $anio;
    private $tecnica;
    private $medidas;
    private $descripcion;
    private $imagen;
    
    private $artista;
    private $tipoObra;
    private $estilo;
    
    public function getIdObra() {
        return $this->idObra;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getAnio() {
        return $this->anio;
    }

    public function getTecnica() {
        return $this->tecnica;
    }

    public function getMedidas() {
        return $this->medidas;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function getArtista() {
        return $this->artista;
    }

    public function getTipoObra() {
        return $this->tipoObra;
    }

    public function getEstilo() {
        return $this->estilo;
    }

    public function setIdObra($idObra) {
        $this->idObra = $idObra;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setAnio($anio) {
        $this->anio = $anio;
    }

    public function setTecnica($tecnica) {
        $this->tecnica = $tecnica;
    }

    public function setMedidas($medidas) {
        $this->medidas = $medidas;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function setArtista(Artista $artista) {
        $this->artista = $artista;
    }

    public function setTipoObra(TipoObra $tipoObra) {
        $this->tipoObra = $tipoObra;
    }

    public function setEstilo(Estilo $estilo) {
        $this->estilo = $estilo;
    }

    public function exchangeArray($data){
            $this->idObra=(isset($data['idObra']))? $data['idObra']:null;
            $this->titulo=(isset($data['titulo']))? $data['titulo']:null;
            $this->anio=(isset($data['anio']))? $data['anio']:null;
            $this->tecnica=(isset($data['tecnica']))? $data['tecnica']:null;
            $this->medidas=(isset($data['medidas']))? $data['medidas']:null;
            $this->imagen = (isset($data['imagen']))  ? $data['imagen']:null; 
            $this->descripcion=(isset($data['descripcion']))? $data['descripcion']:null;
            
            $this->artista=new Artista();
            $this->artista->setIdArtista((isset($data['idArtista']))? $data['idArtista']:null);
            $this->artista->setNombre((isset($data['nombreArtista']))? $data['nombreArtista']:null);
            $this->artista->setFechaNacimiento((isset($data['fechaNacimiento']))? $data['fechaNacimiento']:null);
            $this->artista->setFechaMuerte((isset($data['fechaMuerte']))? $data['fechaMuerte']:null);
            $this->artista->setDireccion((isset($data['direccion']))? $data['direccion']:null);
            $this->artista->setTelefono((isset($data['telefono']))? $data['telefono']:null);
            $this->artista->setSemblanza((isset($data['semblanza']))? $data['semblanza']:null);
            $this->artista->setEmail((isset($data['email']))? $data['email']:null);
            $this->artista->setFacebook((isset($data['facebook']))? $data['facebook']:null);
            $this->artista->setTwitter((isset($data['twitter']))? $data['twitter']:null);
            $this->artista->setLugar((isset($data['lugar']))? $data['lugar']:null);
            
            $this->estilo =new Estilo();            
            $this->estilo->setIdEstilo((isset($data['idEstilo']))? $data['idEstilo']:null);
            $this->estilo->setDescripcion((isset($data['descripcionEstilo']))? $data['descripcionEstilo']:null);
            
            $this->tipoObra=new TipoObra();
            $this->tipoObra->setIdtipoObra((isset($data['idTipoObra']))? $data['idTipoObra']:null);
            $this->tipoObra->setDescripcion((isset($data['descripcionTipoObra']))? $data['descripcionTipoObra']:null);
            
    }
    
    
    public function getArrayCopy(){
        return get_object_vars($this);
    }
    
}





