<?php
class rol extends OrmClass{
    	protected $_datasource = "rol";	public $rol_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $nombre = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setRolId($var){
                $this->rol_id['val'] = $var;
             }	function getRolId(){
                return $this->rol_id['val'];
             }	function setNombre($var){
                $this->nombre['val'] = $var;
             }	function getNombre(){
                return $this->nombre['val'];
             }}