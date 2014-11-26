<?php

namespace Prestamos\Model\Dao;

use Zend\Db\TableGateway\TableGateway;
use Prestamos\Model\Entity\Prestamo;

class PrestamoDao implements IPrestamoDao{

    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function obtenerPorId($id) {
        $id=(int)$id;
        $rowset = $this->tableGateway->select(array('idPrestamo' => $id));
        $row = $rowset->current();
        if(!$row){
            throw new \Exception("No se pudo encontrar la fila");
        }
        return $row;
    }
    
    public function obtenerTodos() {
        //$resultSet = $this->tableGateway->select();
        $select = $this->tableGateway->getSql()->select();
        $select->join(array('obr' => 'obra'),'obr.idObra = prestamo.idObra',array(
            'idDeObra' => 'idObra','tituloObra' => 'titulo'));
        
        $select->join(array('ent' => 'entidad'),'ent.idEntidad = prestamo.idEntidad',array(
            'idDeEntidad' => 'idEntidad','nombreEntidad' => 'nombre'));

        $select->order(array('idPrestamo'));
        
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }
    
    
    public function eliminar(Prestamo $prestamo){
        $this->tableGateway->delete(array('idPrestamo' => $prestamo->getIdPrestamo()));
    }
    
    public function guardar(Prestamo $prestamo){
        $data = array (
            'fechaPrestamo' => $prestamo->getFechaPrestamo(),
            'ubicacion' => $prestamo->getUbicacion(),
            'fechaTentativaRegreso' => $prestamo->getFechaTentativaRegreso(),
            //'fechaRegreso' => $prestamo->getFechaRegreso(),
        );
        if(!empty($prestamo->getFechaRegreso())){
            $data['fechaRegreso']=$prestamo->getFechaRegreso();
        }
        
        if($prestamo->getObra()!==null){
            $data['idObra']=$prestamo->getObra()->getIdObra();
        }
        
        if($prestamo->getEntidad()!==null){
            $data['idEntidad']=$prestamo->getEntidad()->getIdEntidad();
        }
        
        $id = (int) $prestamo->getIdPrestamo();
        if($id == 0){
            $this->tableGateway->insert($data);
        }else{
            if($this->obtenerPorId($id)){
                $this->tableGateway->update($data, array('idPrestamo' => $id));
            }else{
                throw new \Exception("El id del formulario no existe");
            }
        }
    }
    
    
    
}





