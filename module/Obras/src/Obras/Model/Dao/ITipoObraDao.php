<?php

namespace Obras\Model\Dao;
use Obras\Model\Entity\TipoObra;

interface ITipoObraDao {
    
    public function obtenerTodos();
    public function obtenerPorId($id);
    public function guardar(TipoObra $tipoObra);
    public function eliminar(TipoObra $tipoObra);
    
}
