<?php
class estandar extends OrmClass{
    	protected $_datasource = "estandar";	public $estandar_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $nombre = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $estado = Array ('type' => 'tinyint', 'null' =>  'YES', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setEstandarId($var){
                $this->estandar_id['val'] = $var;
             }	function getEstandarId(){
                return $this->estandar_id['val'];
             }	function setNombre($var){
                $this->nombre['val'] = $var;
             }	function getNombre(){
                return $this->nombre['val'];
             }	function setEstado($var){
                $this->estado['val'] = $var;
             }	function getEstado(){
                return $this->estado['val'];
             }}