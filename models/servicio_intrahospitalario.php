<?php
class servicio_intrahospitalario extends OrmClass{
    	protected $_datasource = "servicio_intrahospitalario";	public $servicio_intrahospitalario_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $nombre = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $estandar_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'estandar', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setServicioIntrahospitalarioId($var){
                $this->servicio_intrahospitalario_id['val'] = $var;
             }	function getServicioIntrahospitalarioId(){
                return $this->servicio_intrahospitalario_id['val'];
             }	function setNombre($var){
                $this->nombre['val'] = $var;
             }	function getNombre(){
                return $this->nombre['val'];
             }	function setEstandarId($var){
                $this->estandar_id['val'] = $var;
             }	function getEstandarId(){
                return $this->estandar_id['val'];
             }}