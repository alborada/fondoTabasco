<?php

namespace Usuarios\Model\Entity;

class Usuario {

    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $clave;

    public function __construct($id = null, $nombre = null, $apellido = null, $email = null, $clave = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->clave = $clave;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getClave() {
        return $this->clave;
    }

}

