<?php

namespace Entidades\Model\Dao;
use Entidades\Model\Entity\Entidad;

interface IEntidadDao {

    public function obtenerTodos();
    public function obtenerPorId($id);
    public function guardar(Entidad $entidad);
    public function eliminar(Entidad $entidad);
    
}
