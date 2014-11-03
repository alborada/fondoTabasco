<?php

namespace Obras\Model\Dao;

use Zend\Db\TableGateway\TableGateway;
use Obras\Model\Entity\TipoObra;

class TipoObraDao implements ITipoObraDao{

    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function obtenerPorId($id) {
        $id=(int)$id;
        $rowset = $this->tableGateway->select(array('idtipoObra' => $id));
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
    
    public function obtenerTiposObraSelect(){
        $tiposObras = $this->obtenerTodos();
        $result = array();
        foreach($tiposObras as $tip){
            $result[$tip->getIdtipoObra()] = $tip->getDescripcion();
        }
        return $result;
    }
    
    public function eliminar(TipoObra $tipoObra){
        $this->tableGateway->delete(array('idtipoObra' => $tipoObra->getIdtipoObra()));
    }
    
    public function guardar(TipoObra $tipoObra){
        $data = array (
            'descripcion' => $tipoObra->getDescripcion()
        );
        $id = (int) $tipoObra->getIdtipoObra();
        if($id == 0){
            $this->tableGateway->insert($data);
        }else{
            if($this->obtenerPorId($id)){
                $this->tableGateway->update($data, array('idtipoObra' => $id));
            }else{
                throw new \Exception("El id del formulario no existe");
            }
        }
    }
    
    
    
}
