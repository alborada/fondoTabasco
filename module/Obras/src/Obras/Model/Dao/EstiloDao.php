<?php

namespace Obras\Model\Dao;

use Zend\Db\TableGateway\TableGateway;
use Obras\Model\Entity\Estilo;

class EstiloDao implements IEstiloDao{

    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function obtenerPorId($id) {
        $id=(int)$id;
        $rowset = $this->tableGateway->select(array('idEstilo' => $id));
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
    
    public function eliminar(Estilo $estilo){
        $this->tableGateway->delete(array('idEstilo' => $estilo->getIdEstilo()));
    }
    
    public function guardar(Estilo $estilo){
        $data = array (
            'descripcion' => $estilo->getDescripcion()
        );
        $id = (int) $estilo->getIdEstilo();
        if($id == 0){
            $this->tableGateway->insert($data);
        }else{
            if($this->obtenerPorId($id)){
                $this->tableGateway->update($data, array('idEstilo' => $id));
            }else{
                throw new \Exception("El id del formulario no existe");
            }
        }
    }
    
}





