<?php

namespace Obras\Model\Dao;
use Obras\Model\Entity\Obra;

interface IObraDao {
    
    public function obtenerTodos();
    public function obtenerPorId($id);
    public function guardar(Obra $obra);
    public function eliminar(Obra $obra);    
    public function obtenerObrasSelect();
}
