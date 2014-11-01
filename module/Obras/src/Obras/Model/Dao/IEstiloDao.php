<?php

namespace Obras\Model\Dao;
use Obras\Model\Entity\Estilo;

interface IEstiloDao {

    public function obtenerTodos();
    public function obtenerPorId($id);
    public function guardar(Estilo $estilo);
    public function eliminar(Estilo $estilo);
    
}
