<?php

namespace Artistas\Model\Dao;

use Zend\Db\TableGateway\TableGateway;
use Artistas\Model\Entity\Artista;

class ArtistaDao implements IArtistaDao{

    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function obtenerPorId($id) {
        $id=(int)$id;
        $rowset = $this->tableGateway->select(array('idArtista' => $id));
        $row = $rowset->current();
        if(!$row){
            throw new \Exception("No se pudo encontrar la fila");
        }
        return $row;
    }

    public function obtenerTodos() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function eliminar(Artista $artista){
        $this->tableGateway->delete(array('idArtista' => $artista->getIdArtista()));
    }
    
    public function guardar(Artista $artista){
        $data = array (
            'nombre' => $artista->getNombre(),
            'fechaNacimiento' => $artista->getFechaNacimiento(),
            'fechaMuerte' => $artista->getFechaMuerte(),
            'direccion' => $artista->getDireccion(), 
            'telefono' => $artista->getTelefono(),
            'semblanza' => $artista->getSemblanza(),
            'email' => $artista->getEmail(),
            'facebook' => $artista->getFacebook(),
            'twitter' => $artista->getTwitter(),
            'lugar' => $artista->getLugar(),
        );
        $id = (int) $artista->getIdArtista();
        if($id == 0){
            $this->tableGateway->insert($data);
        }else{
            if($this->obtenerPorId($id)){
                $this->tableGateway->update($data, array('idArtista' => $id));
            }else{
                throw new \Exception("El id del formulario no existe");
            }
        }
    }
    
}





