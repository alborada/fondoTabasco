<?php

namespace Obras\Model\Dao;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Obras\Model\Entity\Obra;
use Obras\Model\Entity\Estilo;
use Artistas\Model\Entity\Artista;

class ObraDao implements IObraDao{
    
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function obtenerPorId($id) {
        $id=(int)$id;
        $rowset = $this->tableGateway->select(array('idObra' => $id));
        $row = $rowset->current();
        if(!$row){
            throw new \Exception("No se pudo encontrar la fila");
        }
        return $row;
    }

    public function obtenerTodos() {
        //$resultSet = $this->tableGateway->select();
        $select = $this->tableGateway->getSql()->select();
        $select->join(array('est' => 'estilo'),'est.idEstilo = obra.idEstilo',array(
            'idDeEstilo' => 'idEstilo','descripcionEstilo' => 'descripcion'));
        
        $select->join(array('tip' => 'tipoobra'),'tip.idtipoObra = obra.idTipoObra',array(
            'idDeTipoObra' => 'idtipoObra','descripcionTipoObra' => 'descripcion'));

        $select->join(array('art' => 'artista'),'art.idArtista = obra.idArtista',array(
            'idDeArtista' => 'idArtista','nombreArtista' => 'nombre'));
        
        $select->order(array('nombreArtista ASC', 'anio ASC'));
        
        //echo $select->getSqlString();
        //die;
        
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }
    
    public function obtenerTodosFiltrado() {
        //$resultSet = $this->tableGateway->select();
        $select = $this->tableGateway->getSql()->select();
        $select->join(array('est' => 'estilo'),'est.idEstilo = obra.idEstilo',array(
            'idDeEstilo' => 'idEstilo','descripcionEstilo' => 'descripcion'));
        
        $select->join(array('tip' => 'tipoobra'),'tip.idtipoObra = obra.idTipoObra',array(
            'idDeTipoObra' => 'idtipoObra','descripcionTipoObra' => 'descripcion'));

        $select->join(array('art' => 'artista'),'art.idArtista = obra.idArtista',array(
            'idDeArtista' => 'idArtista','nombreArtista' => 'nombre'));
        
        $select->where(array('obra.prestada IS NULL'));
        
        $select->order(array('nombreArtista ASC', 'anio ASC'));
        
        //echo $select->getSqlString();
        //die;
        
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

    //VER EN QUE METODO SE UTILIZA
    public function obtenerObrasSelectFiltrado(){
        $obras = $this->obtenerTodosFiltrado();
        $result = array();
        foreach($obras as $obr){
            $result[$obr->getIdObra()] = $obr->getTitulo();
        }
        return $result;
    }
    
    public function obtenerObrasSelect(){
        $obras = $this->obtenerTodosFiltrado();
        $result = array();
        foreach($obras as $obr){
            $result[$obr->getIdObra()] = $obr->getTitulo();
        }
        return $result;
    }
    
    public function eliminar(Obra $obra){
        $this->tableGateway->delete(array('idObra' => $obra->getIdObra()));
    }
    
    public function guardar(Obra $obra){
        $data = array (
            'titulo' => $obra->getTitulo(),
            'anio' => $obra->getAnio(),
            'tecnica' => $obra->getTecnica(),
            'medidas' => $obra->getMedidas(),
            'descripcion' => $obra->getDescripcion(),
            'imagen' => $obra->getImagen(),
        );
        
        if($obra->getEstilo()!==null){
            $data['idEstilo']=$obra->getEstilo()->getIdEstilo();
        }
        
        if($obra->getTipoObra()!==null){
            $data['idTipoObra']=$obra->getTipoObra()->getIdtipoObra();
        }
        
        if($obra->getArtista()!==null){
            $data['idArtista']=$obra->getArtista()->getIdArtista();
        }
        
        $id = (int) $obra->getIdObra();
        if($id == 0){
            $this->tableGateway->insert($data);
        }else{
            if($this->obtenerPorId($id)){
                $this->tableGateway->update($data, array('idObra' => $id));
            }else{
                throw new \Exception("El id del formulario no existe");
            }
        }
    }
    
    public function guardarPrestada(Obra $obra, $fecha){
        
        $data = array (
            'titulo' => $obra->getTitulo(),
            'anio' => $obra->getAnio(),
            'tecnica' => $obra->getTecnica(),
            'medidas' => $obra->getMedidas(),
            'descripcion' => $obra->getDescripcion(),
            'imagen' => $obra->getImagen(),
            'prestada' => $fecha,
        );
        
        if($obra->getEstilo()!==null){
            $data['idEstilo']=$obra->getEstilo()->getIdEstilo();
        }
        
        if($obra->getTipoObra()!==null){
            $data['idTipoObra']=$obra->getTipoObra()->getIdtipoObra();
        }
        
        if($obra->getArtista()!==null){
            $data['idArtista']=$obra->getArtista()->getIdArtista();
        }
        
        $id = (int) $obra->getIdObra();
        if($this->obtenerPorId($id)){
            $this->tableGateway->update($data, array('idObra' => $id));
        }else{
            throw new \Exception("El id del formulario no existe");
        }
    }    
    
    
}
