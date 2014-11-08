<?php

namespace Artistas\Model\Dao;
use Artistas\Model\Entity\Artista;

interface IArtistaDao {

    public function obtenerTodos();
    public function obtenerPorId($id);
    public function guardar(Artista $artista);
    public function eliminar(Artista $artista);
    public function obtenerArtistasSelect();
}
