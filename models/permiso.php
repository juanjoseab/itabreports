<?php
class permiso extends OrmClass{
    	protected $_datasource = "permiso";	public $rol_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'rol', 'val'=>''); 	public $funcion_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'funcion', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setRolId($var){
                $this->rol_id['val'] = $var;
             }	function getRolId(){
                return $this->rol_id['val'];
             }	function setFuncionId($var){
                $this->funcion_id['val'] = $var;
             }	function getFuncionId(){
                return $this->funcion_id['val'];
             }}