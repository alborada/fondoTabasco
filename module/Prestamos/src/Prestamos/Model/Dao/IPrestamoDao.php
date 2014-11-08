<?php

namespace Prestamos\Model\Dao;
use Prestamos\Model\Entity\Prestamo;

interface IPrestamoDao {

    public function obtenerTodos();
    public function obtenerPorId($id);
    public function guardar(Prestamo $prestamo);
    public function eliminar(Prestamo $prestamo);
    
}
