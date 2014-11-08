<?php

namespace Entidades\Model\Dao;

use Zend\Db\TableGateway\TableGateway;
use Entidades\Model\Entity\Entidad;

class EntidadDao implements IEntidadDao{

    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function obtenerPorId($id) {
        $id=(int)$id;
        $rowset = $this->tableGateway->select(array('idEntidad' => $id));
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
    
    public function obtenerEntidadesSelect(){
        $entidades = $this->obtenerTodos();
        $result = array();
        foreach($entidades as $ent){
            $result[$ent->getIdEntidad()] = $ent->getNombre();
        }
        return $result;
    }
    
    public function eliminar(Entidad $entidad){
        $this->tableGateway->delete(array('idEntidad' => $entidad->getIdEntidad()));
    }
    
    public function guardar(Entidad $entidad){
        $data = array (
            'nombre' => $entidad->getNombre(),
            'direccion' => $entidad->getDireccion(), 
            'lugar' => $entidad->getLugar(),
            'telefono' => $entidad->getTelefono(),
            'email' => $entidad->getEmail(),
            'facebook' => $entidad->getFacebook(),
            'twitter' => $entidad->getTwitter()
        );
        $id = (int) $entidad->getIdEntidad();
        if($id == 0){
            $this->tableGateway->insert($data);
        }else{
            if($this->obtenerPorId($id)){
                $this->tableGateway->update($data, array('idEntidad' => $id));
            }else{
                throw new \Exception("El id del formulario no existe");
            }
        }
    }
    
}





