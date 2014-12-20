<?php

namespace Usuarios\Model\Entity;

class Usuario {

    private $idUsuario;
    private $nombre;
    //private $apellido;
    //private $email;
    private $password;
    private $tipo;

    public function __construct($idUsuario = null, $nombre = null, $password = null, $tipo = null) {
        $this->idUsuario = $idUsuario;
        $this->nombre = $nombre;
        $this->password = $password;
        $this->tipo = $tipo;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getTipo() {
        return $this->tipo;
    }

}

